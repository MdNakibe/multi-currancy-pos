<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12" class="pb-0 shadow1 white rounded">
                <v-data-table
                    class="custom-data-table elevation-0"
                    dense
                    :headers="chequeInfoHeaders"
                    :items="paid"
                    :search="searchCheque"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0">
                            <v-toolbar-title class="subtitle-1">Paid Cheque Information List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    v-model="searchCheque"
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Cheque"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'PaidCheque',

    data: () => ({
        chequeInfoHeaders: [
            { text: 'Chq. Date', value: 'cheque_date' },
            { text: 'Cust. Name', value: 'customer.name' },
            { text: 'Contact No', value: 'customer.phone' },
            { text: 'Chque No', value: 'cheque_number' },
            { text: 'Bank Name', value: 'bank_name' },
            { text: 'Branch Name', value: 'branch_name' },
            { text: 'Chq. Status', value: 'cheque_status' },
            { text: 'Chq. Amount', value: 'cheque_amount' },
        ],
        searchCheque: '',
    }),

    computed: {
        paid() {
            return this.$store.getters['cheque/cheques'].filter( cheque => cheque.cheque_status == 'Paid')
        }
    },

    async created() {
        await this.$store.dispatch('cheque/getCheques');
    },
}
</script>

<style>

</style>