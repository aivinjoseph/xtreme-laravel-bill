<script setup>
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { generateWindowStickerPdf } from './windowStickerPdf.js';

const props = defineProps({
    car: { type: Object, required: true },
    dealer: { type: Object, default: () => ({}) },
    publicWebsiteUrl: { type: String, default: '' },
    publicVehicleUrl: { type: String, default: '' },
    mode: { type: String, default: 'branded' },
});

const emit = defineEmits(['back', 'update:mode']);
const mode = computed({
    get: () => props.mode,
    set: (value) => emit('update:mode', value),
});
const pdfUrl = ref('');
const loading = ref(false);
const progress = ref(0);
const status = ref('Preparing vehicle image…');
const error = ref('');
const fallbackNotice = ref('');
let generation = 0;

const releasePdf = () => {
    if (pdfUrl.value) URL.revokeObjectURL(pdfUrl.value);
    pdfUrl.value = '';
};

const generate = async () => {
    if (loading.value) return;

    const currentGeneration = ++generation;
    loading.value = true;
    progress.value = 0;
    status.value = mode.value === 'branded' ? 'Preparing vehicle image…' : 'Preparing PDF…';
    error.value = '';
    fallbackNotice.value = '';
    releasePdf();

    try {
        const result = await generateWindowStickerPdf({
            car: props.car,
            dealer: props.dealer,
            publicWebsiteUrl: props.publicWebsiteUrl,
            publicVehicleUrl: props.publicVehicleUrl,
        }, mode.value, (percent, message) => {
            if (currentGeneration !== generation) return;
            progress.value = percent;
            status.value = message || status.value;
        });

        if (currentGeneration !== generation) return;
        pdfUrl.value = URL.createObjectURL(new Blob([result.bytes], { type: 'application/pdf' }));
        fallbackNotice.value = result.fallbackReason;
    } catch (generationError) {
        if (currentGeneration === generation) {
            error.value = 'The Window Sticker PDF could not be generated. Please try again or contact an administrator.';
        }
    } finally {
        if (currentGeneration === generation) loading.value = false;
    }
};

const print = async () => {
    if (loading.value) return;

    if (!pdfUrl.value) await generate();
    if (!pdfUrl.value) return;

    const printWindow = window.open('', '_blank');
    if (printWindow) {
        printWindow.addEventListener('load', () => {
            window.setTimeout(() => printWindow.print(), 250);
        }, { once: true });
        printWindow.location.href = pdfUrl.value;
    } else {
        window.open(pdfUrl.value, '_blank', 'noopener,noreferrer');
    }
};

watch(mode, generate);
onMounted(generate);
onBeforeUnmount(() => {
    generation += 1;
    releasePdf();
});
</script>

<template>
    <section class="window-sticker-preview">
        <div class="window-sticker-toolbar print:hidden">
            <SecondaryButton type="button" @click="emit('back')">Back to editor</SecondaryButton>
            <div class="window-sticker-actions">
                <div class="window-sticker-mode" role="group" aria-label="Vehicle image style">
                    <button type="button" :class="{ active: mode === 'branded' }" :disabled="loading" @click="mode = 'branded'">Branded cutout</button>
                    <button type="button" :class="{ active: mode === 'original' }" :disabled="loading" @click="mode = 'original'">Original photo</button>
                </div>
                <PrimaryButton type="button" :disabled="loading || !pdfUrl" @click="print">Print Window Sticker</PrimaryButton>
            </div>
        </div>

        <div v-if="loading" class="window-sticker-status">
            <div>{{ status }}</div>
            <div v-if="mode === 'branded'" class="window-sticker-progress"><span :style="{ width: `${progress}%` }"></span></div>
        </div>
        <div v-else-if="error" class="window-sticker-status window-sticker-error">{{ error }}</div>
        <div v-if="fallbackNotice" class="window-sticker-notice print:hidden">{{ fallbackNotice }}</div>
        <iframe v-if="pdfUrl && !loading" :src="pdfUrl" class="window-sticker-pdf" title="Window Sticker PDF preview"></iframe>
    </section>
</template>

<style scoped>
.window-sticker-preview { min-height: 100vh; padding: 1rem; background: #f3f4f6; }
.window-sticker-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 1rem; width: 8.5in; max-width: 100%; margin: 0 auto 1rem; }
.window-sticker-actions { display: flex; align-items: center; gap: .75rem; }
.window-sticker-mode { display: flex; overflow: hidden; border: 1px solid #d1d5db; border-radius: .375rem; background: #fff; }
.window-sticker-mode button { padding: .5rem .7rem; color: #4b5563; font-size: .75rem; }
.window-sticker-mode button + button { border-left: 1px solid #d1d5db; }
.window-sticker-mode button.active { background: #991b1b; color: #fff; }
.window-sticker-mode button:disabled { cursor: wait; opacity: .55; }
.window-sticker-status, .window-sticker-notice { width: 8.5in; max-width: 100%; min-height: 10in; margin: 0 auto; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1rem; background: #fff; color: #4b5563; box-shadow: 0 2px 12px rgb(0 0 0 / 12%); }
.window-sticker-status { min-height: 6rem; padding: 2rem; }
.window-sticker-notice { min-height: 0; margin-bottom: 1rem; padding: .75rem 1rem; color: #92400e; background: #fffbeb; font-size: .875rem; }
.window-sticker-error { color: #991b1b; }
.window-sticker-progress { width: min(22rem, 90%); height: .4rem; overflow: hidden; border-radius: 999px; background: #e5e7eb; }
.window-sticker-progress span { display: block; height: 100%; background: #991b1b; transition: width .2s ease; }
.window-sticker-pdf { display: block; width: 612pt; height: 792pt; max-width: 100%; margin: 0 auto 1.5rem; border: 0; background: #fff; box-shadow: 0 2px 12px rgb(0 0 0 / 12%); }
@media (max-width: 800px) { .window-sticker-toolbar, .window-sticker-actions { align-items: stretch; flex-direction: column; } }
@media print { .window-sticker-preview { min-height: 0; padding: 0; background: #fff; } }
</style>
