<template>
    <v-container fluid >
        <v-row justify="center" class="px-3">
            <v-col cols="12" class="white theme_rounded">
                <purchase-invoice :purchaseId="this.$route.params.id"></purchase-invoice>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import purchaseInvoice from "../../components/purchase-invoice.vue";

export default {
    name: 'PurchaseInvoice',

    components: {
		"purchase-invoice": purchaseInvoice,
    },
}
</script>
