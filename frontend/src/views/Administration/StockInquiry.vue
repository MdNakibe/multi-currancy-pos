<template>
    <v-container fluid class="white shadow1 rounded d-flex" style="min-height: 80dvh;flex-direction: column;">
        
        <!-- <div>
            Scan product to check stock
            <v-combobox 
                dense
                outlined
                hide-details
                v-model="selectedProduct"
                :items="products"
                :loading="$store.getters['product/loadingProducts']"
                :auto-select-first="true"
                item-text="display_text"
                item-value="id"
                :filter="globalFilter"
            >
            </v-combobox>
        </div> -->

        <v-row dense class="m-2">
            <v-col cols="12" class="pb-0">
                <v-toolbar dense color="white" :elevation="0" class="mb-6" style="border-bottom: 1px solid #ccc !important;width:100%;align-items: center;justify-content: space-between;">
                            <v-toolbar-title class="subtitle-3">Check Stock</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Product"
                                    append-icon="mdi-magnify"
                                    style="max-width:300px;"
                                    v-model="searchTerm"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                <v-data-table
                    class="custom-data-table shadow1 rounded overflow-hidden"
                    dense
                    :headers="productHeaders"
                    :items="filteredProducts"
                    :loading="$store.getters['product/loadingProducts']" 
					loading-text="Loading... Please wait"
                >
                    <!-- <template v-slot:top>
                        
                    </template> -->
                    <template v-slot:item.description="{ item }">
                        {{ truncateDescription(item.description) }}
                    </template>
                    <template v-slot:[`item.image`]="{ item }">
                        <v-img
                            :width="50"
                            :height="50"
                            cover
                            :src="`${$store.state.hostName}${item.image}`"
                        />
					</template>
                </v-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import Fuse from 'fuse.js';
export default {
    name: 'StockInquiry',

    data: () => ({
        products: [],
        selectedProduct: null,
        searchProduct: '',
        searchTerm:'',
        stock: null,
        productHeaders: [
            // { text: 'SL', value: 'sl' },
            { text: 'Product ID', value: 'code' },
            { text: 'Image', value: 'image' },
            { text: 'Barcode / QR code', value: 'barcode' },
            { text: 'Product Name', value: 'name' },
            { text: 'Description', value: 'description' },
            { text: 'Category', value: 'category.name' },
            { text: 'Brand', value: 'brand.name' },
            // { text: 'Pack Size', value: 'pack_size' },
            { text: 'Unit', value: 'unit.name' },
            { text: 'Wholesale Rate', value: 'wholesale_rate' },
            { text: 'Retail Rate', value: 'sale_rate' },
        ],
    }),

    // watch: {
    //     async selectedProduct(product) {
    //         console.log(product);
    //         if(product == undefined) return;
    //         if(product.id != '') {
    //             await this.$store.dispatch('product/getTotalStock', {productId: product.id})
    //             let stock = await this.$store.getters['product/stock'][0]
    //             this.stock = stock ? stock : {};
    //         }
    //     },
    // },
    async created() {
        await this.getProducts();

    },
    computed: {
        filteredProducts() {
            const products = this.$store.getters['product/products'];
            if (this.searchTerm === '') {
                return products;
            }else{
                return products.filter(product => this.globalFilter(product, this.searchTerm));
            }
        },
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
        async truncatedDescriptions() {
            return this.$store.getters['product/products'].map(product => {
                const words = product.description.split(' ');
                const truncatedText = words.slice(0, 10).join(' ');
                return truncatedText;
            });
        },
        async getProducts() {
            await this.$store.dispatch('product/getProducts')
            this.products = this.$store.getters['product/products']
        },
        // customFilter(filterableItem, term, display_text) {
        //     const fuseOptions = {
        //         isCaseSensitive: false,
        //         findAllMatches: true,
        //         keys: ['item']
        //     }
        //     const fuseObj = new fuse([{'item': display_text}], fuseOptions)
        //     const op = fuseObj.search(term).map(item => item.item)
        //     if (op.length > 0) {
        //         return true
        //     }
        //     return false
        // },

        
    }
}

</script>

<style lang="scss">
    .v-treeview-node__root {
        // min-height: 35px !important;
        padding-left: 0px !important;
        position: relative;
    }
    .reportBox {
        display: flex;
        min-width: 400px;
        justify-content: space-between;
        border-bottom: 1px solid #ddd;
        padding-bottom: 0.5em;
    }
    .resultBox {
        font-size: 1em;
        margin-top: 20px; 
        height: 100%;
        flex: 1;
        border: 1px solid #ddd;
        display: flex;
        flex-direction: column;
        gap: 1em;
        justify-content: center; 
        align-items: center;
    }
</style>
