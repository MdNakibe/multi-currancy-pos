<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form" @submit.prevent="saveCheque" ref="chequeForm">
                    <v-card class="white shadow1 rounded pb-4">
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-toolbar :elevation="0">
                                    <v-toolbar-title class="subtitle-1">Cheque Entry</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-0 mt-1">
                                    <v-row dense>
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Customer name</v-col>
                                                <v-col cols="8">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="customer"
                                                        @focus="$store.dispatch('customer/getCustomers')"
                                                        :loading="$store.getters['customer/loadingCustomers']"
                                                        :items="$store.getters['customer/customers']"
                                                        item-text="display_text"
                                                        item-value="id"
                                                        :rules="[() => !!cheque.customer_id || 'Select customer']"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Bank Name</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="cheque.bank_name"
                                                        :rules="[() => !!cheque.bank_name || 'Bank name']"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Branch Name</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="cheque.branch_name"
                                                        :rules="[() => !!cheque.branch_name || 'Branch name']"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Cheque No</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="cheque.cheque_number"
                                                        :rules="[() => !!cheque.cheque_number || 'Cheque number']"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4" class="text-right pr-2">Cheque Amount</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="cheque.cheque_amount"
                                                        :rules="[() => !!cheque.cheque_amount || 'Cheque amount']"
                                                        type="number"
                                                        min="0"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4" class="text-right pr-2">Cheque Status</v-col>
                                                <v-col cols="8">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :items="['Pending', 'Paid', 'Dishonoured']"
                                                        v-model="cheque.cheque_status"
                                                        :rules="[() => !!cheque.cheque_status || 'Status']"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1"> 
                                                <v-col cols="4" class="text-right pr-2">Date</v-col>
                                                <v-col cols="8">
                                                    <v-menu>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field
                                                                dense
                                                                outlined
                                                                hide-details
                                                                v-model="cheque.date"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                            >
                                                            <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                            </v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="cheque.date"></v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1"> 
                                                <v-col cols="4" class="text-right pr-2">Cheque Date</v-col>
                                                <v-col cols="8">
                                                    <v-menu>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field
                                                                dense
                                                                outlined
                                                                hide-details
                                                                v-model="cheque.cheque_date"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                required
                                                            >
                                                            <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                            </v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="cheque.cheque_date"></v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1"> 
                                                <v-col cols="4" class="text-right pr-2">Reminder Date</v-col>
                                                <v-col cols="8">
                                                    <v-menu>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field
                                                                dense
                                                                outlined
                                                                hide-details
                                                                v-model="cheque.reminder_date"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                            >
                                                            <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                            </v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="cheque.reminder_date"></v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1"> 
                                                <v-col cols="4" class="text-right pr-2">Submit Date</v-col>
                                                <v-col cols="8">
                                                    <v-menu>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field
                                                                dense
                                                                outlined
                                                                hide-details
                                                                v-model="cheque.submit_date"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                            >
                                                            <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                            </v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="cheque.submit_date"></v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4" class="text-right pr-2">Description</v-col>
                                                <v-col cols="8">
                                                   <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        autocomplete="off"
                                                        v-model="cheque.note"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4"></v-col>
                                                <v-col cols="8">
                                                    <v-row no-gutters>
                                                         <v-col cols="6" class="pr-1">
                                                            <v-btn height="30px" type="submit" dark block color="light-blue darken-2" :loading="saveLoading">Save</v-btn>
                                                        </v-col>
                                                        <v-col cols="6">
                                                            <v-btn height="30px" type="reset" dark block color="deep-orange">Clear</v-btn>
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-form>
            </v-col>
        </v-row>
        <v-row dense class="mt-5">
            <v-col cols="12" class="pb-0">
                <v-data-table
                    class="custom-data-table shadow1 white rounded"
                    :headers="chequeInfoHeaders"
                    :loading="$store.getters['cheque/loading']"
                    :items="$store.getters['cheque/cheques']"
                    :search="searchCheque"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0">
                            <v-toolbar-title class="subtitle-2">Cheque Information List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    v-model="searchCheque"
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Cheque Information"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.cheque_status`]="{ item }">
                        <v-btn tile block small :color="(item.cheque_status == 'Dishonoured') ? 'error' : 'white'">{{ item.cheque_status }}</v-btn>
					</template>
                    <template v-slot:[`item.action`]="{ item }">
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="editCheque(item)" color="primary" v-on="on">mdi-circle-edit-outline</v-icon>
							</template>
							<span>Edit</span>
						</v-tooltip>
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="chequeId = item.id;$refs.confirmDialog.dialog = true" color="error" v-on="on" >mdi-delete-circle-outline</v-icon>
							</template>
							<span>Delete</span>
						</v-tooltip>
					</template>
                </v-data-table>
                <delete-confirm ref="confirmDialog" @confirm="deleteCheques"></delete-confirm>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../../components/confirm-dialog.component";

export default {
    name: 'Cheque',

    components: {
		'delete-confirm': confirmDialog,
    },
    
    data: ()=> ({
        cheque: {
            id: null,
            customer_id: null,
            bank_name: '',
            branch_name: '',
            cheque_number: '',
            cheque_amount: '',
            cheque_status: '',
            date: new Date().toISOString().substr(0, 10),
            cheque_date: new Date().toISOString().substr(0, 10),
            reminder_date: new Date().toISOString().substr(0, 10),
            submit_date: new Date().toISOString().substr(0, 10),
            note: ''
        },
        customer: null,
        chequeInfo: [],
        saveLoading: false,
        chequeId: null,

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
        searchCheque: ''
    }),

    watch: {
        customer(customer) {
            this.cheque.customer_id = customer = null ? null : customer.id;
        }
    },

    async created() {
        await this.getCheques();
    },

    methods: {
        async getCheques() {
            let filter = {
                dateFrom: new Date().toISOString().substr(0, 10),
                dateTo: new Date().toISOString().substr(0, 10)
            }
            await this.$store.dispatch('cheque/getCheques', filter);
        },

        async saveCheque() {
            if(! this.validationForm()) {
                return;
            }
            this.saveLoading = true;

            let Success = await this.$store.dispatch('cheque/saveCheque', this.cheque);

            if(Success) {
                await this.getCheques();
                this.resetForm();
            }

            this.saveLoading = false;
        },

        editCheque(cheque) {
            Object.keys(this.cheque).forEach(key => this.cheque[key] = cheque[key]);
            this.customer = cheque?.customer;
            this.customer.display_text = `${cheque?.customer.code} - ${cheque?.customer.name} - ${cheque?.customer.phone}`;
        },

        async deleteCheques() {
            await this.$store.dispatch('cheque/deleteCheque', this.chequeId);
            await this.getCheques()
            this.$refs.confirmDialog.dialog = false;
        },

        validationForm() {
            let isValid = true;
            this.$refs.chequeForm.validate();
            this.$refs.chequeForm.inputs.forEach(input => {
                if(input.hasError) isValid = false;
            })

            return isValid;
        },

        resetForm() {
            this.$refs.chequeForm.reset();
            this.$refs.chequeForm.resetValidation();
        }
    },
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