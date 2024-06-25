<template>
    <v-container fluid>
        <v-row>
            <v-col cols="6" class="pb-0 shadow1 white rounded px-4 py-5">
                <v-data-table
                    class="custom-data-table"
                    :headers="designationHeaders"
                    :items="$store.getters['designation/designations']"
                    :search="searchDesignation"
                    :loading="$store.getters['designation/loading']" 
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
                                >Designation List</v-toolbar-title
                            >
                            

                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search designation"
                                    append-icon="mdi-magnify"
                                    style="width: 300px"
                                    v-model="searchDesignation"
                                >
                                </v-text-field>
                            </v-form>
                            <v-spacer></v-spacer>
                            <designation-dialog :icon="true" ref="designationDialog"></designation-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="editDesignation(item)"
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
                                    @click="designationId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
                <confirm-dialog ref="confirmDialog" @confirm="deleteDesignation"></confirm-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import designationDialog from "../../components/designation-dialog.component";

export default {
    name: 'Designations',

    components: {
		"confirm-dialog": confirmDialog,
		"designation-dialog": designationDialog,
	},

    data: () => ({
        designationHeaders: [
            { text: 'SL', value: 'sl' },
            { text: ' Name', value: 'name' },
            { text: 'Action', value: 'action' },
        ],
        searchDesignation: "",
        designationId: null,
        loading: false,
        userType: ''
    }),
    
    created() {
        this.$store.dispatch("designation/getDesignations");
        let userData = JSON.parse(localStorage.getItem('userData'));
		this.userType = userData.userType;

    },

    methods: {
        editDesignation(designation){
            Object.keys(this.$refs.designationDialog.designation).forEach(key => {
                this.$refs.designationDialog.designation[key] = designation[key];
            })
            this.$refs.designationDialog.showDesignationDialog = true;
        },

        deleteDesignation(){
            this.$store.dispatch('designation/deleteDesignation', this.designationId);
            this.$refs.confirmDialog.dialog = false;
        }
    }
}
</script>

<style>

</style>