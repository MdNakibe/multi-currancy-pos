<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" class="pb-0">
                <v-data-table
                    class="custom-data-table elevation-1"
                    dense
                    :headers="customerHeaders"
                    :items="$store.getters['customer/types']"
                    :search="searchCustomer"
                    :loading="$store.getters['customer/loadingCustomers']" 
					loading-text="Loading... Please wait"
                >
                    <template v-slot:top>
                        <v-toolbar
                            dense
                            color="white"
                            :elevation="1"
                            height="40"
                        >
                            <v-toolbar-title class="subtitle-2"
                                >Customer Type List</v-toolbar-title
                            >
                            

                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search customer type"
                                    append-icon="mdi-magnify"
                                    style="width: 300px"
                                    v-model="searchCustomer"
                                >
                                </v-text-field>
                            </v-form>
                            <v-spacer></v-spacer>
                            <type-dialog :icon="true" ref="typeDialog"></type-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="editType(item)"
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
                                    @click="typeId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
                <confirm-dialog ref="confirmDialog" @confirm="deleteType"></confirm-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import typeDialog from "../../components/type-dialog.component";

export default {
    name: 'CustomerType',

    components: {
		"confirm-dialog": confirmDialog,
		"type-dialog": typeDialog,
	},

    data() {
        return {
            customerHeaders: [
                { text: 'SL', value: 'sl' },
                { text: 'Type Name', value: 'name' },
                { text: 'Discount', value: 'discount' },
                { text: 'Target Sale', value: 'target' },
                { text: 'Action', value: 'action' },
            ],
            searchCustomer: "",
            typeId: null,
            loading: false,
        }
    },

    async created() {
        await this.$store.dispatch("customer/getTypes");
    },

    methods: {
        editType(type){
            Object.keys(this.$refs.typeDialog.type).forEach(key => {
                this.$refs.typeDialog.type[key] = type[key];
            })
            this.$refs.typeDialog.showTypeDialog = true;
        },

        async deleteType(){
            await this.$store.dispatch('customer/deleteType', this.typeId);
            this.$refs.confirmDialog.dialog = false;
        }
    }
}
</script>

<style>

</style>