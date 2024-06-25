<template>
    <v-container fluid>
        <v-row dense>
            <v-col cols="12" md="9">
                <v-row>
                    <v-col cols="12" class="py-0">
                        <v-card  class="white shadow1 rounded">
                            <v-toolbar color="white" :elevation="0">
                                <v-toolbar-title class="subtitle-1">Customer Entry</v-toolbar-title>
                            </v-toolbar>

                            <v-card-text class="py-0">
                                <v-form ref="customerForm" class="custom-form" @submit.prevent="saveCustomer">
                                    <v-row>
                                        <v-col cols="6" class="pa-2">
                                            <v-row class="pb-2">
                                                <v-col cols="4" class="py-1">Customer Id</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="customer.code"
                                                        :rules="[v => !!v]"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row class="pb-2">
                                                <v-col cols="4" class="py-1">Name</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="customer.name"
                                                        :rules="[v => !!v]"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row class="pb-2">
                                                <v-col cols="4" class="py-1">Company Name</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="customer.org_name"
                                                        :rules="[v => !!v]"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row class="pb-2">
                                                <v-col cols="4" class="py-1">Area</v-col>
                                                <v-col cols="7" class="py-0">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        @focus="$store.dispatch('area/getAreas')"
                                                        :items="$store.getters['area/areas']"
                                                        :loading="$store.getters['area/loadingAreas']"
                                                        item-text="name"
                                                        item-value="id"
                                                        v-model="area"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                                <v-col cols="1" class="py-0 pa-0"  style="margin-left:-12px">
                                                    <area-dialog :icon="true" ref="areaDialog"></area-dialog>
                                                </v-col>
                                            </v-row>
                                            <v-row class="pb-2">
                                                <v-col cols="4" class="py-1">Category</v-col>
                                                <v-col cols="7" class="py-0">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        @focus="$store.dispatch('customer_category/getCategories')"
                                                        :items="$store.getters['customer_category/categories']"
                                                        :loading="$store.getters['customer_category/loadingCategories']"
                                                        item-text="name"
                                                        item-value="id"
                                                        v-model="customer_category_id"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                                <v-col cols="1" class="py-0 pa-0"  style="margin-left:-12px">
                                                    <customer-category-dialog :icon="true" ref="customerCategoryDialog"></customer-category-dialog>
                                                </v-col>
                                            </v-row>

                                            <v-row>
                                                <v-col cols="4" class="py-1">Address</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="customer.address"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-col>

                                        <v-col cols="6" class="pa-2">
                                            <v-row class="pb-2">
                                                <v-col cols="4" class="py-1">Mobile</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="customer.phone"
                                                        type="number"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>

                                            <v-row class="pb-2">
                                                <v-col cols="4" class="py-1">Office Phone</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="customer.org_phone"
                                                        type="number"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>

                                            <v-row class="pb-2">
                                                <v-col cols="4" class="py-1">Email</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="customer.email"
                                                        type="email"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>

                                            <v-row class="pb-2">
                                                <v-col cols="4" class="py-1">Credit Limit</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.number="customer.credit_limit"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>

                                            <v-row class="pb-2">
                                                <v-col cols="4" class="py-1">Customer Type</v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-radio-group
                                                        v-model="customer.type"
                                                        row
                                                    >
                                                        <v-radio
                                                            label="Retail"
                                                            value="Retail"
                                                        ></v-radio>
                                                        <v-radio
                                                            label="Wholesale"
                                                            value="Wholesale"
                                                        ></v-radio>
                                                    </v-radio-group>
                                                </v-col>
                                            </v-row>

                                            <v-row class="pb-2">
                                                <v-col cols="4" class=""></v-col>
                                                <v-col cols="8" class="py-0">
                                                    <v-row no-gutters>
                                                        <v-col cols="6">
                                                            <v-btn type="submit" :loading="waitingForSave" block class="text_bg_fave">Save</v-btn>
                                                        </v-col>
                                                        <v-col cols="6" class="pl-1">
                                                            <v-btn dark block color="deep-orange">Clear</v-btn>
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12" class="pb-0">
                        <v-data-table
                            class="custom-data-table white shadow1 rounded py-4 px-3"
                            :headers="customerHeaders"
                            :items="$store.getters['customer/customers']"
                            :loading="$store.getters['product/loadingProducts']"
                            :search="searchCustomer" 
					        loading-text="Loading... Please wait"
                            @click:row="showDetails"
                        >
                            <template v-slot:top>
                                <v-toolbar dense color="white" :elevation="0">
                                    <v-toolbar-title class="subtitle-2">Customer List</v-toolbar-title>
                                    <v-divider class="mx-4" inset vertical></v-divider>
                                    <v-form class="custom-form">
                                        <v-text-field
                                            outlined
                                            dense
                                            hide-details
                                            placeholder="Search Customer"
                                            append-icon="mdi-magnify"
                                            style="width:300px;"
                                            v-model="searchCustomer"
                                        >
                                        </v-text-field>
                                    </v-form>
                                </v-toolbar>
                            </template>
                            <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin'">
                                <v-tooltip left color="primary">
                                    <template v-slot:activator="{ on }">
                                        <v-icon small @click="editCustomer(item)" color="primary" v-on="on">mdi-circle-edit-outline</v-icon>
                                    </template>
                                    <span>Edit</span>
                                </v-tooltip>
                            </template>

                        </v-data-table>
                    </v-col>
                </v-row>
            </v-col>
            
            <v-col cols="12" md="3">
                <v-card
                    tile
                    class="mx-auto white shadow_f rounded"
                    height="100%"
                    style="width: 100%"
                    :elevation="0"
                >
                    <v-card dark tile flat class="carv_img_wrap rounded text_bg_fave">
                        <v-card-text class="text-center">
                            <!-- <v-avatar color="blue lighten-2" size="50" class="my-2">
                                <span class="white--text headline">C</span>
                            </v-avatar>
                            <h2 class="caption">{{ selectedCustomer.code }}</h2>
                            <h1 class="subtitle-2">{{ selectedCustomer.name }}</h1>
                            <div v-if="userType == 'super_admin' || userType == 'admin'">
                                <v-btn icon color="white" @click="editCustomer(selectedCustomer)">
                                    <v-icon>mdi-account-edit</v-icon>
                                </v-btn>
                                <v-btn icon color="white" @click="customerId = selectedCustomer.id;$refs.confirmDialog.dialog = true">
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </div>
                            -->
                            <img class="carv_img" :src="carv" alt="">
                            <img class="uavatar" :src="`https://ui-avatars.com/api/?name=${selectedCustomer.name}&background=522EA8&color=fff`" alt="alt">
                        </v-card-text>
                    </v-card>
                    
                    <div class="actions_btns">
                        <h2 class="subtitle-1">{{ selectedCustomer.code }}</h2>
                        <h1 class="subtitle-1">{{ selectedCustomer.name }}</h1>
                        <div v-if="userType == 'super_admin' || userType == 'admin'">
                            <v-btn icon color="black" @click="editCustomer(selectedCustomer)">
                                <v-icon>mdi-account-edit</v-icon>
                            </v-btn>
                            <v-btn icon color="black" @click="customerId = selectedCustomer.id;$refs.confirmDialog.dialog = true">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </div>
                    </div>
                    <v-list dense class="info_list">
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">mdi-cellphone</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedCustomer.phone }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        
                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">mdi-phone</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedCustomer.org_phone }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">mdi-email</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedCustomer.email }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        
                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">mdi-credit-card</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedCustomer.credit_limit }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        
                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">mdi-office-building</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedCustomer.org_name }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">mdi-map-marker</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedCustomer.address }}</v-list-item-title>
                                <v-list-item-subtitle>{{ selectedCustomer.area.name }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>

        <delete-confirm ref="confirmDialog" @confirm="deleteCustomer"></delete-confirm>
    </v-container>
</template>

<script>
import areaDialog from '../../components/area-dialog.component'
import utilities from '../../mixins/utility.mixin'
import confirmDialog from '../../components/confirm-dialog.component.vue'
import customerCategoryDialog from '../../components/customer-category-dialog.component.vue'
import carv from '../../assets/shape_avatar.svg'
// import Upcomming from '../../components/upcomming.vue'
export default {
    name: 'Customer',

    mixins: [utilities],

    components: {
        "area-dialog": areaDialog,
        "delete-confirm": confirmDialog,
        'customer-category-dialog': customerCategoryDialog,
    },

    data() {
        return {
            customerHeaders: [
                { text: 'Id', value: 'code' },
                { text: 'Name', value: 'name' },
                { text: 'Company Name', value: 'org_name' },
                { text: 'Category name', value: 'category.name' },
                { text: 'Mobile', value: 'phone' },
                { text: 'Email', value: 'email' },
                { text: 'Action', value: 'action' },
            ],
            searchCustomer: '',
            carv: carv,
            customer: {
                id: null,
                code: '',
                name: '',
                phone: '',
                email: '',
                area_id: null,
                address: '',
                org_name: '',
                org_phone: '',
                credit_limit: 0,
                type: 'Retail'
            },
            selectedCustomer: {
                id: null,
                code: 'C0001',
                name: 'Select a Customer',
                org_name: 'Company Name',
                credit_limit: 0,
                address: 'Customer\'s Address',
                mobile: '01XXXXXXXXX',
                email: 'Customer\'s Email',
                org_phone: 'Office Phone',
                area: 'Area',

            },
            customer_category_id: null,
            area: null,
            customerId: null,
            waitingForSave: false,
            userType: ''
        }
    },

    watch: {
        area(area) {
            if(area == undefined) return;
            this.customer.area_id = area.id;
        },
        customer_category_id(cat) {
            if(cat == undefined) return;
            this.customer.customer_category_id = cat.id;
        }
    },

    async created() {
        this.customer.code = await this.$store.dispatch('customer/generateCustomerCode');
        await this.$store.dispatch('customer/getCustomers');

        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        showDetails(customer) {
            this.selectedCustomer = customer;
        },

        editCustomer(customer) {
             Object.keys(this.customer).forEach(key => {
                this.customer[key] = customer[key];
            })
            
            this.area = customer.area;
            this.customer.type = customer.type
        },

        async saveCustomer() {
             if(!this.validateCustomer()) {
                return;
            }
     
            this.waitingForSave = true
            let success = await this.$store.dispatch('customer/saveCustomer', this.customer);

            if(success) {
                this.resetForm();
            }

            this.waitingForSave = false
        },

        async deleteCustomer() {
            await this.$store.dispatch('customer/deleteCustomer', this.customerId);
            this.$refs.confirmDialog.dialog = false;
        },

        validateCustomer() {
            let isValid = true;
            
            this.$refs.customerForm.validate();

            this.$refs.customerForm.inputs.forEach(input => {
                if(input.hasError) isValid = false;
            })

            if(!isValid) return;

            if(this.customer.area_id == null) {
                this.$store.dispatch('snackbar/error', 'Select a area');
                isValid = false; 
                return isValid;
            }

            return isValid;
        },

        async resetForm() {
            Object.keys(this.customer).map(k => this.customer[k] = '');
            this.$refs.customerForm.resetValidation();
            this.customer.id = null;
            this.area = null;
            this.customer.code = await this.$store.dispatch('customer/generateCustomerCode');
        },
    }
}
</script>

<style lang="scss" scoped>
    .v-input--selection-controls {
        margin-top: 1px !important;
        height: 34px !important;
    }

    .carv_img_wrap {
        position: relative;
        padding-top: 84px;
    }
    .carv_img_wrap .carv_img {
        position: absolute;
        bottom: -26px;
        left: 0;
        right: 0;
        width: 144px;
        height: 62px;
        margin: 0 auto;
    }
    .uavatar {
        width: 64px;
        height: 64px;
        bottom: -32px;
        position: absolute;
        left: 0;
        right: 0;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto;
    }
    .shadow_f {
        box-shadow: rgba(145, 158, 171, 0.16) 0px 4px 8px 0px !important;
    }

    // .info_list {
    //     padding-top: 50px !important;
    // }
    .actions_btns {
        padding-top: 45px;
        text-align: center;
    }
</style>