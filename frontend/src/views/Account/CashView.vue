<template>
    <v-container fluid>
        <v-row dense class="mt-2">
            <v-col cols="4">
                <v-card color="theme_bg_lighter shadow1 rounded">
                    <v-card-text class="text-center">
                        <div class="card-item">
                            <v-icon size="50">mdi-cash-100</v-icon>
                            <div class="title">Cash Balance</div>
                            <div class="amount">Tk. {{ $store.getters['cashTransaction/totalCashBalance'].toFixed(2) }}</div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="4">
                <v-card color="theme_bg_lighter shadow1 rounded">
                    <v-card-text class="text-center">
                        <div class="card-item">
                            <v-icon size="50">mdi-bank</v-icon>
                            <div class="title">Bank Balance</div>
                            <div class="amount">Tk. {{ $store.getters['bankTransaction/totalBankBalance'].toFixed(2) }}</div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="4">
                <v-card color="theme_bg_lighter shadow1 rounded">
                    <v-card-text class="text-center">
                        <div class="card-item">
                            <v-icon size="50">mdi-currency-bdt</v-icon>
                            <div class="title">Total Balance</div>
                            <div class="amount">Tk. {{ totalBalance }}</div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-row dense class="mt-1">
            <v-col cols="3"  v-for="(bankAccount, i) in $store.getters['bankTransaction/banks']" :key="i">
                <v-card elevation="2">
                    <div class="account-item">
                        <v-row no-gutters>
                            <v-col cols="4">
                                <div class="icon">
                                    <v-icon size="50">mdi-currency-bdt</v-icon>
                                </div>
                            </v-col>
                            <v-col cols="8">
                                <div class="content">
                                    <div>{{ bankAccount.account_name }}</div>
                                    <div>{{ bankAccount.account_number }}</div>
                                    <div>{{ bankAccount.bank_name }}</div>
                                    <div class="amount">Tk. {{ bankAccount.balance }}</div>
                                </div>
                            </v-col>
                        </v-row>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "CashView",

    data: () => ({}),

    computed: {
        totalBalance() {
            return (+this.$store.getters['cashTransaction/totalCashBalance'] + +this.$store.getters['bankTransaction/totalBankBalance']).toFixed(2)
        }
    },
    
    async created() {
        await this.$store.dispatch('cashTransaction/getCashBalance')
        await this.$store.dispatch('bankTransaction/getTotalBankBalance')
        await this.$store.dispatch('bankTransaction/getAccountBalance')
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