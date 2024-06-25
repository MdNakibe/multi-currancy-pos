<template>
    <v-container fluid>
        <v-form class="custom-form white shadow1 px-2 py-2 rounded">
            <v-row dense justify="center" style="align-items: center;">
                <v-col cols="1">Invoice No</v-col>
                <v-col cols="2">
                    <v-combobox 
                        dense
                        outlined
                        hide-details
                        v-model="sale"
                        @focus="$store.dispatch('sale/getInvoices')"
                        :items="$store.getters['sale/invoices']"
                        :loading="$store.getters['sale/loadingsale']"
                        item-text="invoice"
                        item-value="id"
                    >
                    </v-combobox>
                </v-col>
            </v-row>
        </v-form>
        <v-divider></v-divider>
        <v-row justify="center">
            <v-col cols="12">
                <sale-invoice :saleId="saleId"  v-if="showInvoice"></sale-invoice>
                <div class="white shadow1 rounded" v-else>
                    <div class="no_result">
                        <div class="img"></div>
                    </div>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import saleInvoice from "../../components/sale-invoice.vue";

export default {
    name: 'PurInvoice',

    components: {
		"sale-invoice": saleInvoice,
    },

    data: () => ({
        sale: null,
        saleId: null,
        showInvoice: false
    }),

    watch: {
        async sale(sale) {
            if(sale == undefined) return;
            this.saleId = sale.id;
            this.viewInvoice();
        }
    },

    methods: {
        async viewInvoice(){
            this.showInvoice = false;
            await new Promise(r => setTimeout(r, 500));
            this.showInvoice = true;
      }
    }
}
</script>

<style scoped>

</style>
