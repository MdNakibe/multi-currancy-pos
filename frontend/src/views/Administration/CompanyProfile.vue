<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form ref="companyProfileForm" @submit.prevent="saveCompanyProfile" class="custom-form">
                    <v-card class="shadow1 white rounded pb-4 px-4">
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-toolbar :elevation="0" style="border-bottom: 1px solid #ddd !important;">
                                    <v-toolbar-title class="subtitle-1">Company Information</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-2 mt-1">
                                    <v-row dense justify="center">
                                        <v-col cols="5">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Company Name</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        :rules="[v => !!v]"
                                                        v-model.trim="company.company_name"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Address</v-col>
                                                <v-col cols="8">
                                                    <v-textarea
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="company.address"
                                                        height="8vh"
                                                    ></v-textarea>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Contact Us</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="company.contact_us"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">E-mail</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="company.email"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Dolor Rate</v-col>
                                                <v-col cols="8">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="company.dolor_rate"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="4">Company Logo</v-col>
                                                <v-col cols="8">
                                                    <v-file-input 
                                                        show-size 
                                                        outlined 
                                                        dense
                                                        hide-details
                                                        @change="onChangeMainImage()"
                                                        prepend-icon=""
                                                        prepend-inner-icon="mdi-camera"
                                                    >
                                                    </v-file-input>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4"></v-col>
                                                <v-col cols="8">
                                                    <v-card tile :elevation="0"> 
                                                        <v-img
                                                            :src="image"
                                                            aspect-ratio="1.8"
                                                            class="grey lighten-2"
                                                            contain
                                                        >
                                                        </v-img>
                                                    </v-card>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-2">
                                                <v-col cols="4">Print Type</v-col>
                                                <v-col cols="8">
                                                   <v-radio-group
                                                        v-model="company.type"
                                                        row
                                                        hide-details
                                                    >
                                                        <v-radio
                                                            label="A4"
                                                            :value="1"
                                                        ></v-radio>
                                                        <v-radio
                                                            label="1/2 A4"
                                                            :value="2"
                                                        ></v-radio>
                                                        <v-radio
                                                            label="POS"
                                                            :value="3"
                                                        ></v-radio>
                                                    </v-radio-group>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="4"></v-col>
                                                <v-col cols="8">
                                                    <v-row no-gutters>
                                                         <v-col cols="6" class="pr-1">
                                                            <v-btn @click="resetForm" dark block color="deep-orange">Clear</v-btn>
                                                        </v-col>
                                                        <v-col cols="6">
                                                            <v-btn type="submit" :loading="saveLoading" block color="text_bg_fave">Save</v-btn>
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
    </v-container>
</template>

<script>
export default {
    name: 'CompanyProfile',
    data: ()=> ({
        company: {
            company_name: '',
            address: '',
            contact_us: '',
            email: '',
            dolor_rate: 0,
            type: ''
        },
        image: '',
        imageFile: null,

        saveLoading: false,
    }),
    async created() {
        await this.$store.dispatch('companyProfile/getCompanyProfile');
        this.company.company_name = this.$store.getters['companyProfile/company'].company_name;
        this.company.address = this.$store.getters['companyProfile/company'].address;
        this.company.contact_us = this.$store.getters['companyProfile/company'].contact_us;
        this.company.email = this.$store.getters['companyProfile/company'].email;
        this.company.type = this.$store.getters['companyProfile/company'].type;
        this.company.dolor_rate = this.$store.getters['companyProfile/company'].dolor_rate;
        this.image = this.$store.getters['companyProfile/company'].image ?`${this.state.host} ${this.$store.getters['companyProfile/company'].image}` : ''
    },
    
    methods: {
        async saveCompanyProfile() {
            if (!this.$refs.companyProfileForm.validate()) return
            this.saveLoading = true;
            await this.$store.dispatch('companyProfile/saveCompanyProfile', { company: this.company, image: this.imageFile })
            this.saveLoading = false;
        },

        onChangeMainImage() {
            if(event.target.files == undefined || event.target.files.length < 1) {
                this.image = '';
                this.imageFile = null;
                return;
            }

            this.imageFile = event.target.files[0];
            this.image = URL.createObjectURL(event.target.files[0]);
        },
        
        resetForm() {
            Object.keys(this.company).map(k => this.company[k] = '')
            this.$refs.companyProfileForm.resetValidation()
        }
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
    .v-messages {
        flex: 1 1 auto;
        font-size: 12px;
        min-height: 0px !important;
        max-height: 0px!important;
        min-width: 1px;
        position: relative;
    }
    .v-input--selection-controls {
        margin-top: 0 !important;
    }
</style>
