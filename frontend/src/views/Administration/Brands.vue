<template>
    <v-container fluid>
        <v-row>
            <v-col cols="6" class="pb-0 white shadow1 rounded">
                <v-data-table
                    class="custom-data-table"
                    :headers="brandHeaders"
                    :items="$store.getters['brand/brands']"
                    :search="searchBrand"
                    :loading="$store.getters['brand/loadingBrands']" 
					loading-text="Loading... Please wait"
                >
                    <template v-slot:top>
                        <v-toolbar
                            dense
                            color="white"
                            :elevation="0"
                            height="50"
                        >
                            <v-toolbar-title class="subtitle-2"
                                >Brand List</v-toolbar-title
                            >
                            

                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search brand"
                                    append-icon="mdi-magnify"
                                    style="width: 300px"
                                    v-model="searchBrand"
                                >
                                </v-text-field>
                            </v-form>
                            <v-spacer></v-spacer>
                            <brand-dialog :icon="true" ref="brandDialog"></brand-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="editBrand(item)"
                                    color="primary"
                                    v-on="on"
                                    >mdi-circle-edit-outline</v-icon
                                >
                            </template>
                            <span>Edit</span>
                        </v-tooltip>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="brandId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
                <confirm-dialog ref="confirmDialog" @confirm="deleteBrand"></confirm-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import brandDialog from "../../components/brand-dialog.component";

export default {
    name: 'Brands',

    components: {
		"confirm-dialog": confirmDialog,
		"brand-dialog": brandDialog,
	},

    data() {
        return {
            brandHeaders: [
                { text: 'SL', value: 'sl' },
                { text: 'Brand Name', value: 'name' },
                { text: 'Action', value: 'action' },
            ],
            searchBrand: "",
            brandId: null,
            loading: false,
            userType: ''
        }
    },

    created() {
        this.$store.dispatch("brand/getBrands");
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;

    },

    methods: {
        editBrand(brand){
            Object.keys(this.$refs.brandDialog.brand).forEach(key => {
                this.$refs.brandDialog.brand[key] = brand[key];
            })
            this.$refs.brandDialog.showBrandDialog = true;
        },
        deleteBrand(){
            this.$store.dispatch('brand/deleteBrand', this.brandId);
            this.$refs.confirmDialog.dialog = false;
        }
    }
}
</script>

<style>

</style>