<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form ref="productForm" @submit.prevent="saveProduct" class="custom-form">
                    <v-card color="white" class="shadow4 mb-5">
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-toolbar color="white" :elevation="1">
                                    <v-toolbar-title class="subtitle-3 d-flex" style="justify-content: space-between;width: 100%;">
                                        Product Entry
                                        <v-btn dark color="primary" to="/product-buld-import" style="color: white !important;">Bulk Product Import</v-btn>
                                    </v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-5 mt-1">
                                    <v-row dense justify="center">
                                        <v-col cols="5">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Product ID</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model.trim="product.code"
                                                        readonly
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Barcode / QR Code</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="product.barcode"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Product Name</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model.trim="product.name"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Description</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="product.description"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Category</v-col>
                                                <v-col cols="8">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="category"
                                                        @focus="$store.dispatch('category/getCategories')"
                                                        :items="$store.getters['category/categories']"
                                                        :loading="$store.getters['category/loadingCategories']"
                                                        item-text="name"
                                                        item-value="id"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                                <v-col cols="1">
                                                    <div class="ml-2">
                                                        <category-dialog :icon="true" ref="categoryDialog"></category-dialog>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                        </v-col>

                                        <v-col cols="5">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Brand</v-col>
                                                <v-col cols="8">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="brand"
                                                        @focus="$store.dispatch('brand/getBrands')"
                                                        :items="$store.getters['brand/brands']"
                                                        :loading="$store.getters['brand/loadingBrands']"
                                                        item-text="name"
                                                        item-value="id"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                                <v-col cols="1">
                                                    <div class="ml-2">
                                                        <brand-dialog :icon="true" ref="brandDialog"></brand-dialog>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Unit</v-col>
                                                <v-col cols="8">
                                                    <v-combobox
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="unit"
                                                        @focus="$store.dispatch('unit/getUnits')"
                                                        :items="$store.getters['unit/units']"
                                                        :loading="$store.getters['unit/loadingUnits']"
                                                        item-text="name"
                                                        item-value="id"
                                                    >
                                                    </v-combobox>
                                                </v-col>
                                                <v-col cols="1">
                                                    <div class="ml-2">
                                                        <unit-dialog :icon="true" ref="unitDialog"></unit-dialog>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Low Stock QTY</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="product.low_stock_qty"
                                                        type="number"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>

                                            <v-row no-gutters class="mb-1" style="display: flex;align-items: center;">
                                                <v-col cols="3" class="text-right pr-2">Product Image</v-col>
                                                <v-col cols="8">
                                                    <v-file-input 
                                                        chips
                                                        accept="image/*"
                                                        label="Image"
                                                        @change="(e) => onFileChange(e)"
                                                    >
                                                    </v-file-input>
                                                </v-col>
                                            </v-row>
                                            <v-row v-if="product.image" no-gutters class="mb-1" style="display: flex;align-items: center;">
                                                <v-col cols="3" class="text-right pr-2">Image preview</v-col>
                                                <v-col cols="8">
                                                    <img style="display:block;width:100px;" :src="`${$store.state.hostName}${product.image}`" alt="">
                                                    <v-btn color="red" dark @click="() => {
                                                        product.image=''
                                                        removeImg=true
                                                    }">Remove</v-btn>
                                                </v-col>
                                            </v-row>

                                            <v-row no-gutters>
                                                <v-col cols="3"></v-col>
                                                <v-col cols="8">
                                                    <v-row no-gutters>
                                                        <v-col cols="6">
                                                            <v-btn type="submit" :loading="waitingForSave" height="30px" dark block color="primary">Save</v-btn>
                                                        </v-col>
                                                        <v-col cols="6" class="pl-1">
                                                            <v-btn @click="resetForm" height="30px" dark block color="deep-orange">Clear</v-btn>
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

        <v-row dense class="mt-1">
            <v-col cols="12" class="pb-0">
                <v-data-table
                    class="custom-data-table shadow1 rounded overflow-hidden"
                    dense
                    :headers="productHeaders"
                    :items="$store.getters['product/products']"
                    :search="searchProduct"
                    :loading="$store.getters['product/loadingProducts']" 
					loading-text="Loading... Please wait"
                >
                <template v-slot:item.description="{ item }">
                    {{ truncateDescription(item.description) }}
                </template>
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0" class="mb-6" style="border-bottom: 1px solid #ccc !important;width:100%;align-items: center;justify-content: space-between;">
                            <v-toolbar-title class="subtitle-3">Product List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Product"
                                    append-icon="mdi-magnify"
                                    style="max-width:300px;"
                                    v-model="searchProduct"
                                >
                                </v-text-field>
                            </v-form>
                            <div style="margin-left: auto">
                                <v-btn @click="print" color="primary">Print Price List</v-btn>
                                <v-btn @click="printProductList" color="teal" style="margin-left: 10px;" dark>Print Product List</v-btn>
                            </div>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.image`]="{ item }">
                        <v-img
                            :width="50"
                            :height="50"
                            cover
                            :src="`${$store.state.hostName}${item.image}`"
                        />
					</template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
                        <v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="$router.push(`/barcode-generate/${item.id}`)" color="primary" v-on="on">mdi-barcode</v-icon>
							</template>
							<span>Barcode</span>
						</v-tooltip>
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="editProduct(item)" color="primary" v-on="on">mdi-circle-edit-outline</v-icon>
							</template>
							<span>Edit</span>
						</v-tooltip>
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="productId = item.id;$refs.confirmDialog.dialog = true" color="error" v-on="on">mdi-delete-circle-outline</v-icon>
							</template>
							<span>Delete</span>
						</v-tooltip>
					</template>
                </v-data-table>
            </v-col>
        </v-row>

        <div v-show="false" id="invoiceContent">
            <v-simple-table class="bordered-table">
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product ID</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Unit</th>
                            <th>Average Purchase Rate</th>
                            <th>Wholesale Rate</th>
                            <th>Retail Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in $store.getters['product/products']" :key="product.sl">
                            <td class="text-center">{{ product.sl }}</td>
                            <td class="text-center">{{ product.code }}</td>
                            <td class="text-center">
                                <img :src="`${$store.state.hostName}/${product.image}`" alt="">
                            </td>
                            <td class="text-center">{{ product.name }}</td>
                            <td class="text-center">{{ lodash.get(product, 'category.name') }}</td>
                            <td class="text-center">{{ lodash.get(product, 'brand.name') }}</td>
                            <td class="text-center">{{ lodash.get(product, 'unit.name') }}</td>
                            <td class="text-center">{{ product.purchase_rate }}</td>
                            <td class="text-center">{{ product.wholesale_rate }}</td>
                            <td class="text-center">{{ product.sale_rate }}</td>
                        </tr>
                        <tr v-if="$store.getters['product/products'].length == 0">
                            <td colspan="9" class="text-center">Product information is not available</td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </div>
        <div v-show="false" id="productListContent">
            <v-simple-table class="bordered-table">
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product ID</th>
                            <th>Product Image</th>
                            <th>Barcode</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in $store.getters['product/products']" :key="product.sl">
                            <td class="text-center">{{ product.sl }}</td>
                            <td class="text-center">{{ product.code }}</td>
                            <td class="text-center">
                                <img :src="`${$store.state.hostName}/${product.image}`" alt="">
                            </td>
                            <td class="text-center">{{ product.barcode }}</td>
                            <td class="text-center">{{ product.name }}</td>
                            <td class="text-center">{{ lodash.get(product, 'category.name') }}</td>
                            <td class="text-center">{{ lodash.get(product, 'brand.name') }}</td>
                            <td class="text-center">{{ lodash.get(product, 'unit.name') }}</td>
                        </tr>
                        <tr v-if="$store.getters['product/products'].length == 0">
                            <td colspan="9" class="text-center">Product information is not available</td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </div>

        <delete-confirm ref="confirmDialog" @confirm="deleteProduct"></delete-confirm>

    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import categoryDialog from "../../components/category-dialog.component";
import brandDialog from "../../components/brand-dialog.component";
import unitDialog from "../../components/unit-dialog.component";
import { handlePrint } from "../../composable/usePrint";
import { hostName,  host } from "../../composable/useConfig";
// import XLSX from 'xlsx';
export default {
    name: '',
    components: {
        'delete-confirm': confirmDialog,
        "category-dialog": categoryDialog,
        "brand-dialog": brandDialog,
        "unit-dialog": unitDialog,
    },
    data: ()=> ({
        productHeaders: [
            { text: 'SL', value: 'sl' },
            { text: 'Product ID', value: 'code' },
            { text: 'Image', value: 'image' },
            { text: 'Barcode / QR code', value: 'barcode' },
            { text: 'Product Name', value: 'name' },
            { text: 'Description', value: 'description' },
            { text: 'Category', value: 'category.name' },
            { text: 'Brand', value: 'brand.name' },
            // { text: 'Pack Size', value: 'pack_size' },
            { text: 'Unit', value: 'unit.name' },
            { text: 'Avg Purchase Rate (USD)', value: 'purchase_detail_sum_avarage_usd' },
            { text: 'Avg Purchase Rate (SRD)', value: 'purchase_detail_sum_avarage_srd' },
            { text: 'Wholesale Rate (USD)', value: 'wholesale_rate' },
            { text: 'Wholesale Rate (SRD)', value: 'wholesale_rate_SRD' },
            { text: 'Retail Rate (SRD)', value: 'sale_rate' },
            { text: 'Action', value: 'action' },
        ],
        searchProduct: '',
        product: {
            id: null,
            code: '',
            name: '',
            barcode: '',
            pack_size: '',
            description: '',
            image: '',
            category_id: null,
            brand_id: null,
            unit_id: null,
            purchase_rate: 0,
            purchase_detail_sum_avarage_usd: 0,
            sale_rate: '',
            wholesale_rate: '',
            low_stock_qty: '',
        },
        removeImg: false,
        image_upload: null,
        category: null,
        brand: null,
        unit: null,
        products: [],
        waitingForSave: false,
        productId: null,
        userType: '',
    }),
    watch: {
        category(category) {
            if(category == undefined) return
            this.product.category_id = category.id;
        },

        brand(brand) {
            if(brand == undefined) return
            this.product.brand_id = brand.id;
        },

        unit(unit) {
            if(unit == undefined) return
            this.product.unit_id = unit.id;
        }
    },
    async created() {
        this.product.code = await this.$store.dispatch('product/generateProductCode');
        await this.$store.dispatch('product/getProducts');
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },
    methods: {
        truncateDescription(description) {
            if (typeof description === 'string') {
                const words = description.split(' ');
                if (words.length > 20) {
                return words.slice(0, 20).join(' ') + '...'; 
                } else {
                return description;
                }
            } else {
                return description;
            }
        },
        onFileChange(file){
            this.image_upload = file;
            // const reader = new FileReader()
            // reader.readAsDataURL(file)
            // reader.onload = e => {
            //     console.log(e.target.result)
            // }
        },

        async saveProduct() {
            if(!this.validateProduct()) {
                return;
            }
     
            this.waitingForSave = true
            
            let opt = {
                product: this.product,
                image: this.image_upload,
            }
            if (this.removeImg) {
                opt.removeImg = true;
            }
            this.removeImg = false
            let success = await this.$store.dispatch('product/saveProduct', opt);

            if(success) {
                this.resetForm();
            }

            this.waitingForSave = false
        },

        editProduct(product) {
            Object.keys(this.product).forEach(key => {
                this.product[key] = product[key];
            })

            this.category = product.category;
            this.brand = product.brand;
            this.unit = product.unit;
            this.image = product.image;
            this.purchase_detail_sum_avarage_usd = product.purchase_detail_sum_avarage_usd;
        },

        deleteProduct() {
            this.$store.dispatch('product/deleteProduct', this.productId);
            this.$refs.confirmDialog.dialog = false;
        },

        validateProduct() {
            let isValid = true;
            
            this.$refs.productForm.validate();

            this.$refs.productForm.inputs.forEach(input => {
                if(input.hasError) isValid = false;
            })

            if(!isValid) return;

            if(this.product.category_id == null) {
                this.$store.dispatch('snackbar/error', 'Select a category');
                isValid = false; 
                return isValid;
            }

            if(this.product.brand_id == null) {
                this.$store.dispatch('snackbar/error', 'Select a brand');
                isValid = false; 
                return isValid;
            }

            if(this.product.unit_id == null) {
                this.$store.dispatch('snackbar/error', 'Select an unit');
                isValid = false; 
                return isValid;
            }

            return isValid;
        },

        async resetForm() {
            Object.keys(this.product).map(k => this.product[k] = '');
            this.$refs.productForm.resetValidation();
            this.product.id = null;
            this.category = null;
            this.brand = null;
            this.unit = null;
            this.image_upload = null;
            this.product.code = await this.$store.dispatch('product/generateProductCode');
        },
        async print() {
            let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
            handlePrint({
                title: 'Product price list',
                content: invoiceContent,
            })
        },
        async printProductList() {
            let invoiceContent = document.querySelector('#productListContent').innerHTML;
            handlePrint({
                title: 'Product List',
                content: invoiceContent,
            })
        },
        // downloadDemoExcel() {
        //     // Create a sample data array
        //     const data = [
        //         ['Name', 'Age'],
        //         ['John', 30],
        //         ['Jane', 25],
        //         ['Bob', 40],
        //     ];

        //     // Create a worksheet
        //     const ws = XLSX.utils.aoa_to_sheet(data);

        //     // Create a workbook with the worksheet
        //     const wb = XLSX.utils.book_new();
        //     XLSX.utils.book_append_sheet(wb, ws, 'DemoSheet');

        //     // Generate a Blob containing the Excel file
        //     const blob = XLSX.write(wb, { bookType: 'xlsx', type: 'blob' });

        //     // Create a URL for the Blob and trigger the download
        //     const url = window.URL.createObjectURL(blob);
        //     const a = document.createElement('a');
        //     a.style.display = 'none';
        //     a.href = url;
        //     a.download = 'demo.xlsx';
        //     document.body.appendChild(a);
        //     a.click();

        //     // Clean up
        //     window.URL.revokeObjectURL(url);
        //     document.body.removeChild(a);
        // },
    }
}
</script>

<style lang="scss" scoped>
    .v-icon.v-icon {
       font-size: 18px !important;
       top: -3px !important;
    }
    .v-icon.v-icon[data-v-1f38b4e5] {
        font-size: 14px !important;
        top: 0px !important; 
    }
    .v-toolbar__content {
        width: 100%;
    }
    .v-toolbar__content {
        width: 100% !important;
    }
    .v-toolbar .v-toolbar__content {
        width: 100% !important;
    }
</style>
