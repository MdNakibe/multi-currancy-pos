<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12" class="pb-0 shadow1 white rounded">
                <v-data-table
                    class="custom-data-table"
                    :headers="chequeInfoHeaders"
                    :items="pending"
                    :search="searchCheque"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0">
                            <v-toolbar-title class="subtitle-1">Pending Cheque Information List</v-toolbar-title>
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
                    <template v-slot:[`item.action`]="{ item }">
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="chequeId = item.id;$refs.confirmDialog.dialog = true;$refs.confirmDialog.text = 'paid cheque'" color="primary" v-on="on">mdi-circle-edit-outline</v-icon>
							</template>
							<span>Change Status</span>
						</v-tooltip>
					</template>
                </v-data-table>
                <delete-confirm ref="confirmDialog" @confirm="changeStatus"></delete-confirm>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../../components/confirm-dialog.component";

export default {
    name: 'PendingCheque',

    components: {
		'delete-confirm': confirmDialog,
    },

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
            { text: 'Action', value: 'action' },
        ],
        searchCheque: '',
        chequeId: null
    }),

    computed: {
        pending() {
            return this.$store.getters['cheque/cheques'].filter( cheque => cheque.cheque_status == 'Pending')
        }
    },

    async created() {
        await this.$store.dispatch('cheque/getCheques');
    },

    methods: {
        changeStatus() {
            this.$store.dispatch('cheque/changeStatus', { id: this.chequeId })
            this.$refs.confirmDialog.dialog = false;
        }
    }
}
</script>

<style>

</style>