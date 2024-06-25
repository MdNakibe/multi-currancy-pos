<template>
    <v-container fluid>
        <v-row dense class="mt-1">
            <v-col cols="8">
                <v-card class="pa-5 white shadow1 theme_rounded" style="border: 2px solid var(--theme_dark) !important;">
                    <v-progress-linear
                        color="primary"
                        indeterminate
                        style="width: 100% !important;"
                        v-if="$store.getters['report/loadingProfitLoss']"
                    ></v-progress-linear> 
                    <v-simple-table>
                        <template v-slot:default>
                            <tbody style="font-weight: bold;font-size: 25px;">
                                <tr>
                                    <td>Total sale</td>
                                    <td style="text-align: right;">{{ profitloss.total_sale }}</td>
                                </tr>
                                <tr>
                                    <td>Total sale</td>
                                    <td style="text-align: right;">{{ profitloss.total_vat }}</td>
                                </tr>
                                <tr>
                                    <td>Total transport</td>
                                    <td style="text-align: right;">{{ profitloss.total_transport }}</td>
                                </tr>
                                <tr>
                                    <td>Total discount</td>
                                    <td style="text-align: right;">{{ profitloss.total_discount }}</td>
                                </tr>
                                <tr>
                                    <td>Total return amount</td>
                                    <td style="text-align: right;">{{ profitloss.total_return_amount }}</td>
                                </tr>
                                <tr>
                                    <td>Total damage amount</td>
                                    <td style="text-align: right;">{{ profitloss.total_damage_amount }}</td>
                                </tr>
                                <tr>
                                    <td>Total cost of sale</td>
                                    <td style="text-align: right;">{{ profitloss.total_cost_of_sale }}</td>
                                </tr>
                                <tr>
                                    <td>Gross profit</td>
                                    <td style="text-align: right;">{{ profitloss.gross_profit }}</td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "ProfitLoss",

    data: () => ({
        profitloss: {},
    }),

    computed: {
        totalBalance() {
            return (+this.$store.getters['cashTransaction/totalCashBalance'] + +this.$store.getters['bankTransaction/totalBankBalance']).toFixed(2)
        }
    },

    async created() {
        await this.$store.dispatch('cashTransaction/getCashBalance')
        await this.$store.dispatch('bankTransaction/getTotalBankBalance')
        await this.$store.dispatch('bankTransaction/getAccountBalance')
        await this.$store.dispatch('report/getProfitLoss')
        let profitloss = this.$store.getters['report/profitLoss']
        this.profitloss = profitloss;
    }
};
</script>

<style lang="scss" scoped>
.card-item {
    color: rgba(0, 0, 0, 0.808);

    .theme--light.v-icon {
        color: rgba(0, 0, 0, 0.747);
    }

    .title {
        font-size: 22px !important;
        font-weight: normal !important;
        padding-top: 5px;
    }

    .amount {
        font-size: 28px;
        padding: 12px 0;
    }
}

.account-item {
    text-align: center;
    font-size: 13px;
    color: black;
    line-height: 18px;

    .icon {
        background: #247195;
        height: 100%;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;

        .v-icon {
            margin-top: 27px;
            color: #ffffff;
        }
    }

    .content {
        padding: 7px 0;

        .amount {
            font-size: 20px;
            padding: 7px 0;
        }
    }
}
</style>