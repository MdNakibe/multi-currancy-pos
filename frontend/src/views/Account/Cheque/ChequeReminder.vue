<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12" class="pb-0 shadow1 white rounded">
                <v-data-table
                    class="custom-data-table"
                    :headers="chequeInfoHeaders"
                    :items="$store.getters['cheque/cheques']"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0">
                            <v-toolbar-title class="subtitle-1">Reminder Cheque Information List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
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
                    <template v-slot:[`item.cheque_status`]="{ item }">
                        <v-btn height="24px" tile block  small :color="(item.cheque_status == 'Dishonoured') ? 'error' : 'white'">{{ item.cheque_status }}</v-btn>
					</template>
                </v-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>

export default {
    name: 'ChequeReminder',

    data: ()=> ({
        chequeInfoHeaders: [
            { text: 'Date', value: 'date' },
            { text: 'Cheq. Date', value: 'cheque_date' },
            { text: 'Remi. Date', value: 'reminder_date' },
            { text: 'Sub. Date', value: 'submit_date' },
            { text: 'Cheque No', value: 'cheque_number' },
            { text: 'Bank Name', value: 'bank_name' },
            { text: 'Customer Name', value: 'customer.name' },
            { text: 'Cheq. Status', value: 'cheque_status' },
            { text: 'Cheq. Amount', value: 'cheque_amount' },
        ],
    }),

    async created() {
        await this.$store.dispatch('cheque/getCheques', {reminder: true})
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: 3px !important;
    }
    .v-icon.v-icon[data-v-1f38b4e5] {
        font-size: 14px !important;
        top: 0px !important; 
    }
    .v-messages {
        flex: 1 1 auto;
        font-size: 12px;
        min-height: 0px !important;
        max-height: 0px!important;
        min-width: 1px;
        position: relative;
    }
</style>