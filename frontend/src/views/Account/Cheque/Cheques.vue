<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form class="custom-form white py-4 px-3 shadow1 rounded mb-5" @submit.prevent="getRecord">
                    <v-row dense>
                        <v-col cols="2">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="3">Type</v-col>
                                <v-col cols="9">
                                    <v-combobox 
                                        v-model="searchType"
                                        dense
                                        outlined
                                        hide-details
                                        :items="['All', 'By Customer']"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="3"  v-if="searchType == 'By Customer'">
                            <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                <v-col cols="4">Customer</v-col>
                                <v-col cols="8">
                                    <v-combobox 
                                        dense
                                        outlined
                                        hide-details
                                        v-model="customer"
                                        @focus="$store.dispatch('customer/getCustomers')"
                                        :items="$store.getters['customer/customers']"
                                        :loading="$store.getters['customer/loading']"
                                        item-text="display_text"
                                        item-value="id"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="5">
                            <v-row no-gutters>
                                <v-col cols="6">
                                    <v-row no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                        <v-col cols="4">Date From</v-col>
                                        <v-col cols="8">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="dateFrom"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="dateFrom"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="6">
                                    <v-row class="pl-3" no-gutters style="margin-top: 3px;color: #000;align-items: center;">
                                        <v-col cols="4">Date To</v-col>
                                        <v-col cols="8">
                                            <v-menu>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="dateTo"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    >
                                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="dateTo"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="1" class="d-flex align-center">
                            <v-btn type="submit" dark color="text_bg_fave" :loading="loading">Search</v-btn>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                </v-form>
            </v-col>
        </v-row>

        <v-row dense>
            <v-col cols="12" class="pb-0">
                <v-data-table
                    class="custom-data-table shadow1 white rounded"
                    :headers="chequeInfoHeaders"
                    :loading="$store.getters['cheque/loading']"
                    :items="$store.getters['cheque/cheques']"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0">
                            <v-toolbar-title class="subtitle-2">Cheque Information List</v-toolbar-title>
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
                    <template v-slot:[`item.action`]="{ item }">
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="cheque = item;chequeDetails = true" color="primary" v-on="on">mdi-eye</v-icon>
							</template>
							<span>View</span>
						</v-tooltip>
					</template>
                </v-data-table>
                <v-dialog v-model="chequeDetails" max-width="500" light>
					<v-card>
						<v-toolbar dark dense :elevation="0" color="#061e95">
							<v-toolbar-title>Cheque Details</v-toolbar-title>

                            <v-spacer></v-spacer>
                            <v-btn
                                dark
                                icon
                                color="white" 
                                @click="chequeDetails = false"
                            >
                                X
                            </v-btn>
						</v-toolbar>
						<v-card-text class="py-1">
							<table>
								<tr>
									<td>Cheque No</td>
									<td> : </td>
									<td>{{ cheque.cheque_number }}</td>
								</tr>
								<tr>
									<td>Bank Name</td>
									<td> : </td>
									<td>{{ cheque.bank_name }}</td>
								</tr>
								<tr>
									<td>Branch Name</td>
									<td> : </td>
									<td>{{ cheque.branch_name }}</td>
								</tr>
								<tr>
									<td>Customer Id</td>
									<td> : </td>
									<td>{{ cheque.customer.code }}</td>
								</tr>
								<tr>
									<td>Customer Name</td>
									<td> : </td>
									<td>{{ cheque.customer.name }}</td>
								</tr>
								<tr>
									<td>Contact No</td>
									<td> : </td>
									<td>{{ cheque.customer.phone }}</td>
								</tr>
								<tr>
									<td>Date</td>
									<td> : </td>
									<td> {{ cheque.date }} </td>
								</tr>
								<tr>
									<td>Cheque Date</td>
									<td> : </td>
									<td>{{ cheque.cheque_date }}</td>
								</tr>
								<tr>
									<td>Reminder Date</td>
									<td> : </td>
									<td>{{ cheque.reminder_date }}</td>
								</tr>
								<tr>
									<td>Submit Date</td>
									<td> : </td>
									<td>{{ cheque.reminder_date }}</td>
								</tr>
								<tr>
									<td>Amount</td>
									<td> : </td>
									<td>{{ cheque.cheque_amount }}</td>
								</tr>
								<tr>
									<td>Note</td>
									<td> : </td>
									<td>{{ cheque.note }}</td>
								</tr>
								<tr>
									<td>Cheque Status</td>
									<td> : </td>
									<td>{{ cheque.cheque_status }}</td>
								</tr>
							</table>
						</v-card-text>
					</v-card>
				</v-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'Cheques',

    data: () => ({
        chequeInfoHeaders: [
            { text: 'Cheque Date', value: 'cheque_date' },
            { text: 'Submit Date', value: 'submit_date' },
            { text: 'Cheque No', value: 'cheque_number' },
            { text: 'Bank Name', value: 'bank_name' },
            { text: 'Branch Name', value: 'bank_name' },
            { text: 'Customer Name', value: 'customer.name' },
            { text: 'Cheque Status', value: 'cheque_status' },
            { text: 'Cheque Amount', value: 'cheque_amount' },
            { text: 'Action', value: 'action' },
        ],
        searchType: '',
        dateFrom: new Date().toISOString().substr(0, 10),
        dateTo: new Date().toISOString().substr(0, 10),
        customer: null,
        chequeDetails: false,
        cheque: {
            customer: {}
        },
        loading: false
    }),

    created() {

    },

    methods: {
        async getRecord() {
            if(this.searchType == 'All') {
                this.customer = null;
            }
            let filter = {
                dateFrom: this.dateFrom,
                dateTo: this.dateTo,
                customerId: this.customer == null ? null : this.customer.id
            }

            this.loading = true;
            await this.$store.dispatch('cheque/getCheques', filter)
            this.loading = false;
        }
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: 3px !important;
    }
    .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {
        font-size: 11px;
        padding: 0px 1px;
        // background: #061e95;
        // color: #fff;
        // border: 1px solid #ccc;
        text-align: center;
        // height: 24px !important;
    }
    .v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td {
        // height: 20px !important;
        padding: 0px 5px !important;
        font-size: 12px !important;
        border: 1PX solid #ccc !important;
    }
    table {
	    border:none;
    }
    table td {
		padding:0px 10px;
    }
    table td:first-child {
		font-weight: bold;
	}
</style>