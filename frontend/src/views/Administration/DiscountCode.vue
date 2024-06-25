<template>
    <v-container fluid>
        <v-row no-gutters style="width: 100%;">
            <v-form ref="companyProfileForm" @submit.prevent="handleSaveCode" class="custom-form" style="width: 100%;">
                <v-card class="shadow1 white theme_rounded pb-4 px-4 mb-5">
                    <v-toolbar :elevation="0" style="border-bottom: 1px solid #ddd !important;">
                        <v-toolbar-title class="subtitle-1">Create code</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text class="py-2 mt-1">
                        <v-row>
                            <v-col cols="2">Code</v-col>
                            <v-col cols="8">
                                <v-text-field
                                    dense
                                    outlined
                                    hide-details
                                    :rules="[v => !!v]"
                                    v-model.trim="form.code"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-btn
                                    dense
                                    color="blue"
                                    @click="generateCode"
                                    type="button"
                                    block
                                    dark
                                >Generate</v-btn>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="2">Percentage</v-col>
                            <v-col cols="10">
                                <v-text-field
                                    dense
                                    outlined
                                    hide-details
                                    :rules="[
                                        v => !!v,
                                        v => v <= 100
                                    ]"
                                    v-model.number="form.amount"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="2">Select employee</v-col>
                            <v-col cols="10">
                                <v-combobox 
                                    dense
                                    outlined
                                    hide-details
                                    @focus="$store.dispatch('employee/getEmployees')"
                                    :items="$store.getters['employee/employees']"
                                    :loading="$store.getters['employee/loadingEmployees']"
                                    item-text="display_text"
                                    item-value="id"
                                    :rules="[v => !!v]"
                                    v-model="employee"
                                >
                                </v-combobox>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="2">How many time this code could use?</v-col>
                            <v-col cols="10">
                                <v-text-field
                                    dense
                                    outlined
                                    hide-details
                                    :rules="[v => !!v]"
                                    v-model.number="form.max_limit"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="2"></v-col>
                            <v-col cols="10" style="display: flex;justify-content: end;">
                                <v-btn
                                    dense
                                    color="primary"
                                    type="submit"
                                    dark
                                >Save</v-btn>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-form>
            <v-col cols="12" class="pb-0 white shadow1 rounded">
                <v-data-table
                    class="custom-data-table"
                    :headers="brandHeaders"
                    :items="$store.getters['discount_code/discount_code']"
                    :search="searchBrand"
                    :loading="$store.getters['discount_code/loadingDiscountCode']" 
					loading-text="Loading... Please wait"
                >
                    <template v-slot:top>
                        <v-toolbar
                            dense
                            color="white"
                            :elevation="0"
                            height="50"
                        >
                            <v-toolbar-title class="subtitle-2"
                                >Manage discount code</v-toolbar-title>

                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search brand"
                                    append-icon="mdi-magnify"
                                    style="width: 300px"
                                    v-model="searchBrand"
                                >
                                </v-text-field>
                            </v-form>
                            <v-spacer></v-spacer>
                            <brand-dialog :icon="true" ref="brandDialog"></brand-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="codeId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
                <confirm-dialog ref="confirmDialog" @confirm="deleteCode"></confirm-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import brandDialog from "../../components/brand-dialog.component";

export default {
    name: 'DiscountCode',

    components: {
		"confirm-dialog": confirmDialog,
		"brand-dialog": brandDialog,
	},

    data() {
        return {
            brandHeaders: [
                { text: 'SL', value: 'sl' },
                { text: 'Employee', value: 'employee.name' },
                { text: 'Code', value: 'code' },
                { text: 'Use limit', value: 'use_limit' },
                { text: 'Already used', value: 'used' },
                { text: 'Percentage', value: 'amount' },
                { text: 'Action', value: 'action' },
            ],
            form: {
                code: null,
                amount: 0,
                emp_id: null,
                max_limit: 1,
            },
            employee: null,
            searchBrand: "",
            codeId: null,
            loading: false,
            userType: ''
        }
    },

    watch: {
        employee(employee) {
            if (employee==null || employee == '') return
            this.form.emp_id = employee.id
        }
    },

    created() {
        this.$store.dispatch("discount_code/getDiscountCode");
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        generateCode() {
            let code = Math.floor(Math.random() * 900000) + 100000;
            this.form.code = code
        },
        handleSaveCode(){
            // console.log(this.form);
            this.$store.dispatch("discount_code/saveDiscountCode", {
                discount_code: this.form
            });
        },

        editBrand(brand){
            Object.keys(this.$refs.brandDialog.brand).forEach(key => {
                this.$refs.brandDialog.brand[key] = brand[key];
            })
            this.$refs.brandDialog.showBrandDialog = true;
        },
        deleteCode(){
            this.$store.dispatch('discount_code/deleteDiscountCode', this.codeId);
            this.$refs.confirmDialog.dialog = false;
        }
    }
}
</script>

<style>

</style>