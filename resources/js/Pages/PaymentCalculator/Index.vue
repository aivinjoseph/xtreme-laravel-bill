<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from '@/Components/TextInput.vue';
import { computed, ref } from 'vue';

const form = ref({
    newVehiclePrice: 25000,
    tradeInVehiclePrice: 0,
    loanBalance: 0,
    downPayment: 0,
    loanDuration: 96,
    interestRate: 4,
    provincialSalesTax: 13,
});

const result = computed(() => {
    const { total, monthlyPayment, frequency } = calculate();
    return {
        total,
        monthlyPayment,
        frequency
    };
});

const calculate = () => {
    const data = form.value;
    const netVehiclePrice = data.newVehiclePrice - data.tradeInVehiclePrice;

    // Calculate the provincial sales tax.
    const provincialSalesTaxAmount = (netVehiclePrice * data.provincialSalesTax) / 100;

    // Calculate the total finance amount.
    const totalFinanceAmount = (netVehiclePrice + provincialSalesTaxAmount - data.downPayment + data.loanBalance);

    // Calculate the monthly interest rate.
    const monthlyInterestRate = data.interestRate / 100 / 12;

    // Calculate the monthly payment amount.
    const monthlyPaymentAmount = (totalFinanceAmount * (monthlyInterestRate * (1 + monthlyInterestRate)**data.loanDuration)) / ((1 + monthlyInterestRate)**data.loanDuration - 1);

    const weeklyPaymentAmount = monthlyPaymentAmount / 4.33;
    const biweeklyPaymentAmount = monthlyPaymentAmount / 2.16;

    return {
        total: totalFinanceAmount,
        monthlyPayment: monthlyPaymentAmount,
        weeklyPayment: weeklyPaymentAmount,
        biweeklyPayment: biweeklyPaymentAmount,
        frequency: [
            {
                label: 'Total Finance Amount',
                value: totalFinanceAmount,
            },
            {
                label: 'Weekly',
                value: weeklyPaymentAmount,
            },
            {
                label: 'Bi-Weekly',
                value: biweeklyPaymentAmount,
            },
            {
                label: 'Monthly',
                value: monthlyPaymentAmount,
            },
        ]
    }
}
</script>

<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 lg:px-16 py-8">
            <h1 class="text-2xl font-bold">Payment Calculator</h1>
            <form class="mt-4 grid grid-cols-1 lg:grid-cols-4 gap-4">
                <div>
                    <InputLabel for="name" value="New Vehicle Price" />
                    <TextInput id="name" v-model="form.newVehiclePrice" type="number" class="mt-1 block w-full" required autofocus autocomplete="newVehiclePrice" />
                </div>
                <div>
                    <InputLabel for="name" value="Trade-in Vehicle Price" />
                    <TextInput id="name" v-model="form.tradeInVehiclePrice" type="number" class="mt-1 block w-full" required autofocus autocomplete="tradeInVehiclePrice" />
                </div>
                <div>
                    <InputLabel for="name" value="Existing Vehicle Loan Balance" />
                    <TextInput id="name" v-model="form.loanBalance" type="number" class="mt-1 block w-full" required autofocus />
                </div>
                <div>
                    <InputLabel for="name" value="Down Payment" />
                    <TextInput id="name" v-model="form.downPayment" type="number" class="mt-1 block w-full" required autofocus />
                </div>
                <div>
                    <InputLabel for="name" value="Duration of Loan (Weeks)" />
                    <TextInput id="name" v-model="form.loanDuration" type="number" class="mt-1 block w-full" required autofocus />
                </div>
                <div>
                    <InputLabel for="name" value="Interest Rate (%)" />
                    <TextInput id="name" v-model="form.interestRate" type="number" class="mt-1 block w-full" required autofocus autocomplete="interestRate" />
                </div>
                <div>
                    <InputLabel for="name" value="Provincial Sales Tax (%)" />
                    <TextInput id="name" v-model="form.provincialSalesTax" type="number" class="mt-1 block w-full" required autofocus autocomplete="provincialSalesTax" />
                </div>
            </form>
            <div class="mt-8 flex justify-between w-full bg-gray-100 rounded p-8 py-4">
                <div class="flex flex-col gap-4 text-center" v-for="p in result.frequency" :key="p.label">
                    <span class="font-semibold text-gray-500">{{ p.label }}</span>
                    <span class="text-2xl text-gray-800 font-semibold">${{ p.value.toFixed(2) }}</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>