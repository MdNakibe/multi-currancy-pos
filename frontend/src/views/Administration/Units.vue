<template>
    <v-container fluid>
        <v-row>
            <v-col cols="6"  class="white shadow1 rounded">
                <v-data-table
                    class="custom-data-table"
                    :headers="unitHeaders"
                    :items="$store.getters['unit/units']"
                    :search="searchUnit"
                    :loading="$store.getters['unit/loadingUnits']" 
					loading-text="Loading... Please wait"
                >
                    <template v-slot:top>
                        <v-toolbar
                            dense
                            color="white"
                            :elevation="0"
                            height="50"
                        >
                            <v-toolbar-title class="subtitle-1"
                                >Unit List</v-toolbar-title
                            >
                            

                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Unit"
                                    append-icon="mdi-magnify"
                                    style="width: 300px"
                                    v-model="searchUnit"
                                >
                                </v-text-field>
                            </v-form>
                            <v-spacer></v-spacer>
                            <unit-dialog :icon="true" ref="unitDialog"></unit-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="editUnit(item)"
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
                                    @click="unitId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
                <confirm-dialog ref="confirmDialog" @confirm="deleteUnit"></confirm-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import unitDialog from "../../components/unit-dialog.component";

export default {
    name: 'Units',

    components: {
		"confirm-dialog": confirmDialog,
		"unit-dialog": unitDialog,
	},

    data() {
        return {
            unitHeaders: [
                { text: 'SL', value: 'sl' },
                { text: 'Unit Name', value: 'name' },
                { text: 'Action', value: 'action' },
            ],
            searchUnit: "",
            unitId: null,
            loading: false,
        }
    },

    created() {
        this.$store.dispatch("unit/getUnits");
    },

    methods: {
        editUnit(unit){
            Object.keys(this.$refs.unitDialog.unit).forEach(key => {
                this.$refs.unitDialog.unit[key] = unit[key];
            })
            this.$refs.unitDialog.showUnitDialog = true;
        },
        deleteUnit(){
            this.$store.dispatch('unit/deleteUnit', this.unitId);
            this.$refs.confirmDialog.dialog = false;
        }
    }
}
</script>

<style>

</style>