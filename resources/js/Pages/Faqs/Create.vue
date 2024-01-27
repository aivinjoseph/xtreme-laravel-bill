<script setup>
    import { useForm } from "@inertiajs/vue3";
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    import InputLabel from "@/Components/InputLabel.vue";
    import TextInput from "@/Components/TextInput.vue";
    import TextArea from "@/Components/TextArea.vue";
    import InputError from "@/Components/InputError.vue";
    import PrimaryButton from "@/Components/PrimaryButton.vue";

    const props = defineProps({
        faq: {
            type: Object,
        },
    });

    const form = useForm({
        question: props.faq?.question ?? "",
        answer: props.faq?.answer ?? "",
    });

    const submit = () => {
        if (props.faq) {
            form.put(route("faqs.update", props.faq.id));
        } else {
            form.post(route("faqs.store"));
        }
    };
</script>

<template>
    <AdminLayout title="Create Faqs">
        <div class="max-w-7xl mx-auto p-8 flex flex-col lg:flex-row justify-center gap-8">
            <form class="w-2/4">
                <div>
                    <InputLabel for="question" value="Question" />
                    <TextInput id="question" type="text" class="w-full" v-model="form.question"></TextInput>
                    <InputError class="mt-2" :message="form.errors.question" />
                </div>
                <div class="mt-4">
                    <InputLabel for="answer" value="Answer" />
                    <TextArea id="answer" type="text" class="w-full" v-model="form.answer"></TextArea>
                    <InputError class="mt-2" :message="form.errors.answer" />
                </div>
                
                <div class="mt-4 flex justify-end">
                    <PrimaryButton @click="submit">Submit</PrimaryButton>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>