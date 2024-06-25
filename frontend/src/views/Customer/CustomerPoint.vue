<template>
    <v-container>
        <v-row>
            <v-col cols="6">
                <v-card>
                    <v-toolbar color="white" :elevation="1" height="30px">
                        <v-toolbar-title class="subtitle-1">Point Earn Rate</v-toolbar-title>
                    </v-toolbar>

                    <v-card-text class="py-5">
                        <v-form ref="customerForm" class="custom-form" @submit.prevent="savePointRate">
                            <v-row>
                                <v-col cols="4">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model="point"
                                        :rules="[v => !!v]"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="2" class="font-weight-black">&nbsp;&nbsp; BDT</v-col>
                                <v-col cols="1" class="font-weight-black">&nbsp;=</v-col>
                                <v-col cols="2" class="font-weight-black">1 Point</v-col>
                                <v-col cols="3">
                                    <v-btn type="submit" :loading="loading" height="28px" dark block color="light-blue darken-2">Update</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="6">
                <v-card>
                    <v-toolbar color="white" :elevation="1" height="30px">
                        <v-toolbar-title class="subtitle-1">Point Expense Rate</v-toolbar-title>
                    </v-toolbar>

                    <v-card-text class="py-5">
                        <v-form ref="customerForm" class="custom-form" @submit.prevent="saveExpensePoint">
                            <v-row>
                                <v-col cols="2" class="font-weight-black">1 Point</v-col>
                                <v-col cols="1" class="font-weight-black">&nbsp;=</v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        dense
                                        outlined
                                        hide-details
                                        v-model="rate"
                                        :rules="[v => !!v]"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="2" class="font-weight-black">&nbsp;&nbsp; BDT</v-col>
                                <v-col cols="3">
                                    <v-btn type="submit" :loading="saveLoading" height="28px" dark block color="light-blue darken-2">Update</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'CustomerPoint',

    data: () => ({
        point: 0,
        rate: 0,
        loading: false,
        saveLoading: false
    }),

    async created() {
        await this.$store.dispatch('companyProfile/getCompanyProfile');
        this.point = this.$store.getters['companyProfile/company'].point;
        this.rate = this.$store.getters['companyProfile/company'].rate;
    },

    methods: {
        async savePointRate() {
            let data = {
                point: this.point
            }
            this.loading = true;
            await this.$store.dispatch('companyProfile/saveCompanyProfile', { company: data })
            this.loading = false;
        },

         async saveExpensePoint() {
            let data = {
                rate: this.rate
            }
            this.saveLoading = true;
            await this.$store.dispatch('companyProfile/saveCompanyProfile', { company: data })
            this.saveLoading = false;
        }
    }
}
</script>

<style>

</style>