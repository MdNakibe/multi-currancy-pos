<template>
    <v-container fluid class="white shadow1 rounded">
        <v-row>
            <v-col cols="12" class="pb-0">
                <v-data-table
                    class="custom-data-table"
                    
                    :headers="categoryHeaders"
                    :items="$store.getters['category/categories']"
                    :search="searchCategory"
                    :loading="$store.getters['category/loadingCategories']" 
					loading-text="Loading... Please wait"
                >
                    <template v-slot:top>
                        <v-toolbar
                            color="white"
                            :elevation="0"
                            height="50"
                            style="border-bottom: 1px solid #ddd !important;margin-bottom: 20px !important;"
                        >
                            <v-toolbar-title class="subtitle-1"
                                >Category List</v-toolbar-title
                            >
                            

                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search category"
                                    append-icon="mdi-magnify"
                                    style="width: 300px"
                                    v-model="searchCategory"
                                >
                                </v-text-field>
                            </v-form>
                            <v-spacer></v-spacer>
                            <category-dialog :icon="true" ref="categoryDialog"></category-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="editCategory(item)"
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
                                    @click="categoryId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
                <confirm-dialog ref="confirmDialog" @confirm="deleteCategory"></confirm-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import categoryDialog from "../../components/category-dialog.component";

export default {
    name: 'Categories',

    components: {
		"confirm-dialog": confirmDialog,
		"category-dialog": categoryDialog,
	},

    data() {
        return {
            categoryHeaders: [
                { text: 'SL', value: 'sl' },
                { text: 'Category Name', value: 'name' },
                { text: 'Description', value: 'description' },
                { text: 'Action', value: 'action' },
            ],
            searchCategory: "",
            categoryId: null,
            loading: false,
            userType: ''
        }
    },

    created() {
        this.$store.dispatch("category/getCategories");
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        editCategory(category){
            Object.keys(this.$refs.categoryDialog.category).forEach(key => {
                this.$refs.categoryDialog.category[key] = category[key];
            })
            this.$refs.categoryDialog.showCategoryDialog = true;
        },
        deleteCategory(){
            this.$store.dispatch('category/deleteCategory', this.categoryId);
            this.$refs.confirmDialog.dialog = false;
        }
    }
}
</script>

<style>

</style>