<template>
    <v-container fluid class="white shadow1 rounded">
        <v-row>
            <v-col cols="12" class="pb-0">
                <v-data-table
                    class="custom-data-table elevation-0"
                    :headers="expenseHeaders"
                    :items="$store.getters['expense/expenses']"
                    :search="searchExpense"
                    :loading="$store.getters['expense/loadingExpense']" 
					loading-text="Loading... Please wait"
                >
                    <template v-slot:top>
                        <v-toolbar
                            color="white"
                            :elevation="0"
                            height="50"
                        >
                            <v-toolbar-title class="subtitle-2">Expense Account List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search expense"
                                    append-icon="mdi-magnify"
                                    style="width: 300px"
                                    v-model="searchExpense"
                                >
                                </v-text-field>
                            </v-form>
                            <v-spacer></v-spacer>
                            <expense-dialog :icon="true" ref="expenseDialog"></expense-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="editexpense(item)"
                                    color="primary"
                                    v-on="on"
                                    >mdi-circle-edit-outline</v-icon
                                >
                            </template>
                            <span>Edit</span>
                        </v-tooltip>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="expenseId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
                <confirm-dialog ref="confirmDialog" @confirm="deleteExpense"></confirm-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import expenseDialog from "../../components/expense-dialog.component";

export default {
    name: 'ExpenseAccount',

    components: {
		"confirm-dialog": confirmDialog,
		"expense-dialog": expenseDialog,
	},

    data() {
        return {
            expenseHeaders: [
                { text: 'SL', value: 'sl' },
                { text: 'Expense Name', value: 'name' },
                { text: 'Description', value: 'description' },
                { text: 'Action', value: 'action' },
            ],
            searchExpense: "",
            expenseId: null,
            loading: false,
            userType: ''
        }
    },

    created() {
        this.$store.dispatch("expense/getExpenses");
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        editexpense(expense){
            Object.keys(this.$refs.expenseDialog.expense).forEach(key => {
                this.$refs.expenseDialog.expense[key] = expense[key];
            })
            this.$refs.expenseDialog.showExpenseDialog = true;
        },
        deleteExpense(){
            this.$store.dispatch('expense/deleteExpense', this.expenseId);
            this.$refs.confirmDialog.dialog = false;
        }
    }
}
</script>

<style>

</style>