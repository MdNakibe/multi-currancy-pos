<template>
    <v-container fluid>
        <v-row>
            <v-col cols="6" class="pb-0">
                <v-data-table
                    class="custom-data-table shadow1 white rounded px-4 py-5"
                    :headers="areaHeaders"
                    :items="$store.getters['area/areas']"
                    :search="searchArea"
                    :loading="$store.getters['area/loadingAreas']" 
					loading-text="Loading... Please wait"
                >
                    <template v-slot:top>
                        <v-toolbar
                            dense
                            color="white"
                            :elevation="0"
                            style="border-bottom:1px solid #ddd !important;"
                        >
                            <v-toolbar-title class="subtitle-1"
                                >Area List</v-toolbar-title
                            >
                            

                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search Area"
                                    append-icon="mdi-magnify"
                                    style="width: 300px"
                                    v-model="searchArea"
                                >
                                </v-text-field>
                            </v-form>
                            <v-spacer></v-spacer>
                            <area-dialog :icon="true" ref="areaDialog"></area-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="editArea(item)"
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
                                    @click="areaId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
                <confirm-dialog ref="confirmDialog" @confirm="deleteArea"></confirm-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import areaDialog from "../../components/area-dialog.component";

export default {
    name: "Areas",

    components: {
		"confirm-dialog": confirmDialog,
		"area-dialog": areaDialog,
	},

    data() {
        return {
            areaHeaders: [
                { text: "SL", value: "sl" },
                { text: "Name", value: "name" },
                { text: "Action", value: "action" },
            ],
            searchArea: "",
            areaId: null,
            loading: false,
            userType: ''
        };
    },

    created() {
        this.$store.dispatch("area/getAreas");
        let userData = JSON.parse(localStorage.getItem('userData'));
		this.userType = userData.userType;

    },

    methods: {
        editArea(area) {
            Object.keys(this.$refs.areaDialog.area).forEach(key => {
                this.$refs.areaDialog.area[key] = area[key];
            })
            this.$refs.areaDialog.showAreaDialog = true;
        },
        deleteArea() {
            this.$store.dispatch('area/deleteArea', this.areaId);
            this.$refs.confirmDialog.dialog = false;
        },
    },
};
</script>

<style>
</style>
