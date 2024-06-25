<template>
    <v-container fluid>
        <v-row justify="center">
            <!-- <v-col cols="12" v-if="company.type == '3'">
                <sale-invoice-pos :saleId="this.$route.params.id"></sale-invoice-pos>
            </v-col>
            <v-col cols="12" v-else>
            </v-col> -->
            <sale-invoice :saleId="this.$route.params.id"></sale-invoice>
        </v-row>
    </v-container>
</template>

<script>
import saleInvoicePos from "../../components/sale-invoice-pos.vue";
import saleInvoice from "../../components/sale-invoice.vue";

export default {
    name: 'SaleInvoices',
    data: () => ({
        company: {
            company_name: '',
            address: '',
            contact_us: '',
            email: '',
            type: ''
        },
    }),

    async created() {
        await this.$store.dispatch('companyProfile/getCompanyProfile');
        this.company.company_name = this.$store.getters['companyProfile/company'].company_name;
        this.company.address = this.$store.getters['companyProfile/company'].address;
        this.company.contact_us = this.$store.getters['companyProfile/company'].contact_us;
        this.company.email = this.$store.getters['companyProfile/company'].email;
        this.company.type = this.$store.getters['companyProfile/company'].type;
    },

    components: {
		"sale-invoice": saleInvoice,
		"sale-invoice-pos": saleInvoicePos,
    },
}
</script>
