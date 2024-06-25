<template>
    <v-container fluid>
        <h2>Product Bulk Import</h2>
        <div class="white shadow1 rounded mt-4">
            <v-form class="custom-form" @submit.prevent="handleBulkImport">
                <v-row class="pb-4">
                    <v-col class="pa-10">
                        <strong>Select a excel</strong>
                        <div class="mb-5">
                            <!-- <v-file-input
                                show-size
                                truncate-length="20"
                                label="Select csv file"
                            ></v-file-input> -->
                            <input type="file" @input="e => handleFileSelect(e.target.files[0])" name="excelfile">
                        </div>
                        <div v-if="lodash.size(shit_names)">
                            <v-combobox
                                dense
                                outlined
                                hide-details
                                v-model="shit.selected_shit"
                                :items="shit_names"
                            >
                            </v-combobox>
                        </div>
                        <div>
                            
                        </div>
                    </v-col>
                </v-row>
            </v-form>
        </div>
        <div class="white shadow1 rounded mt-4">
            <v-form class="custom-form" @submit.prevent="handleBulkImportSubmit">
                <v-row class="pb-4">
                    <v-col class="pa-10">
                        <strong class="mb-3 d-flex" style="justify-content: space-between;align-items: center;">
                            <!-- Please have a lock and submit -->
                            <!-- <v-btn :loading="loadingSheet" @click="handleFileSelect" color="green" dark>Reload</v-btn> -->
                        </strong>
                        <div>
                            <v-alert
                                dense
                                text
                                type="warning"
                                v-if="analyzeReport"
                            >
                                <div v-html="analyzeReport"></div>
                            </v-alert>
                            
                            <v-data-table
                                :headers="headers"
                                :items="desserts"
                                :items-per-page="5"
                                class="elevation-1"
                                :loading="loadingSheet"
                            >
                                <!-- <template v-slot:[`item.name`]="{ item }">
                                    <tr>
                                        <td>{{ item.name }}</td>
                                    </tr>
                                </template> -->
                            </v-data-table>
 
                        </div>
                        <div v-if="lodash.size(desserts) > 0 && !this.analyzeReport" style="display: flex;justify-content: end;margin-top: 30px;">
                            <v-btn @click="handleBulkImportSubmit" color="green" dark>Sync</v-btn>
                        </div>
                    </v-col>
                </v-row>
            </v-form>
        </div>
    </v-container>
</template>

<script>
import { read, utils, readFile } from "xlsx";
import _ from 'lodash';
import axios from 'axios'

export default {
    name: 'PurchaseBulkImport',
    data: () => ({
        product: null,
        loading: false,
        show: false,
        desserts: [],
        benched: 5,
        headers: [
            // { text: 'Product code', value: 'code' },
            { text: 'Name', value: 'name' },
            { text: 'Supplier Code', value: 'supplier_code' },
            { text: 'Employe Code', value: 'employe_code' },
            { text: 'Description', value: 'description' },
            { text: 'Brand', value: 'brand' },
            { text: 'Category', value: 'category' },
            { text: 'Purchase rate (USD)', value: 'purchase_rate_USD' },
            { text: 'Sale rate (USD)', value: 'sale_rate_USD' },
            { text: 'Wholesale rate (USD)', value: 'wholesale_rate_USD' },
            // { text: 'Wholesale rate (SRD)', value: 'wholesale_rate_SRD' },
            { text: 'Purchase Qty', value: 'purchase_qty' },
            { text: 'Low stock qty', value: 'low_stock_qty' },
            { text: 'Unit', value: 'unit' },
        ],
        requiredColumn: [
            'supplier_code','employe_code', 'name', 'brand', 'category', 'purchase_rate_USD', 'sale_rate_USD','wholesale_rate_USD', 'unit', 'purchase_qty',
        ],
        shit: {
            html: '',
            selected_shit: null,
        },
        analyzeReport: '',
        products: [],
        workbook: null,
        shit_names: null,
        loadingSheet: false,
    }),

    async created() {
        await this.$store.dispatch('product/getProducts')
        this.products = this.$store.getters['product/products']
    },

    mounted() {
        // this.desserts = Array.from({ length: 500000 }, (k, v) => v + 1)
        // console.log(canvasDatagrid);
        // this.handleFileSelect()
    },
    watch: {
        'shit.selected_shit'(selected_shit) {
            // console.log(selected_shit);
            this.handleShit(selected_shit)
        },
    },

    methods: {
        handleShit(selected_shit) {
            this.desserts = utils.sheet_to_json(this.workbook.Sheets[selected_shit]);
            this.analyzeProduct()
        },
        async handleFileSelect(inputFile=null) {
            // this.loadingSheet = true;
            // try {
            //     // let url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSBKBpkmtLBHMYGNQwi1Y9wqZwfCSZIg3KKgPnPnlXjpu7e5QhAO00E8KcCVFTuPez-_AMEGl85pDk4/pub?output=xlsx'
            //     let url = 'https://docs.google.com/spreadsheets/d/1a6vzCQOt_LFxN5x3z3CWsGIlyQgPBbJzDqj5vNOMWBw/pub?output=xlsx'
            //     let bynary = await axios.get(url, { responseType: 'arraybuffer' }).then(res => res.data)
            //     const data = new Uint8Array(bynary);
            //     const wb = read(data, {type: 'array'});
            //     this.workbook = wb;
            //     this.shit_names = wb.SheetNames;
            //     this.shit.selected_shit = wb.SheetNames[0];
            //     // console.log(wb);
            // } catch (error) {
            //     console.log(error);
            //     this.loadingSheet = false
            // }
            // this.loadingSheet = false
            // // console.log(utils.sheet_to_json(wb));
            if (!inputFile) {
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                const bstr = e.target.result;
                const wb   = read(bstr, { type: 'binary' });

                this.workbook           = wb;
                this.shit_names         = wb.SheetNames;
                this.shit.selected_shit = wb.SheetNames[0];
            }
            reader.readAsBinaryString(inputFile);
        },
        analyzeProduct() {
            let items = this.desserts;
            if (_.size(items) == 0) return;
            let single_item = items[0];
            let targetKey   = this.requiredColumn
            let foundKey    = Object.keys(single_item)
            let missing     = targetKey.filter(column => !foundKey.includes(column));
            if (missing.length) {
                this.analyzeReport += `<div>${missing.join(', ')} missing  ${missing.length > 1 ? 'columns' : 'column'} </div>`;
            }

        },

        async handleBulkImportSubmit() {
            await this.$store.dispatch('product/bulkImportPurchase', this.desserts);
            this.$router.push('/purchases');
        },
    }
}

</script>

<style lang="scss" scoped>
.form_default {
    border: 1px solid #ddd;
    padding: 3px 5px;
}

</style>