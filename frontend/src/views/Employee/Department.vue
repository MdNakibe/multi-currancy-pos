<template>
    <v-container fluid>
        <v-row>
            <v-col cols="6" class="pb-0 shadow1 white rounded">
                <v-data-table
                    class="custom-data-table"
                    :headers="departmentHeaders"
                    :items="$store.getters['department/departments']"
                    :search="searchDepartment"
                    :loading="$store.getters['department/loading']" 
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
                                >Department List</v-toolbar-title
                            >
                            

                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search department"
                                    append-icon="mdi-magnify"
                                    style="width: 300px"
                                    v-model="searchDepartment"
                                >
                                </v-text-field>
                            </v-form>
                            <v-spacer></v-spacer>
                            <department-dialog :icon="true" ref="departmentDialog"></department-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="editDepartment(item)"
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
                                    @click="departmentId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
                <confirm-dialog ref="confirmDialog" @confirm="deleteDepartment"></confirm-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import departmentDialog from "../../components/department-dialog.component";

export default {
    name: 'Departments',

    components: {
		"confirm-dialog": confirmDialog,
		"department-dialog": departmentDialog,
	},

    data: () => ({
        departmentHeaders: [
            { text: 'SL', value: 'sl' },
            { text: 'Department Name', value: 'name' },
            { text: 'Action', value: 'action' },
        ],
        searchDepartment: "",
        departmentId: null,
        loading: false,
        userType: ''

    }),
    
    created() {
        this.$store.dispatch("department/getDepartments");
        let userData = JSON.parse(localStorage.getItem('userData'));
		this.userType = userData.userType;
    },

    methods: {
        editDepartment(department){
            Object.keys(this.$refs.departmentDialog.department).forEach(key => {
                this.$refs.departmentDialog.department[key] = department[key];
            })
            this.$refs.departmentDialog.showDepartmentDialog = true;
        },

        deleteDepartment(){
            this.$store.dispatch('department/deleteDepartment', this.departmentId);
            this.$refs.confirmDialog.dialog = false;
        }
    }
}
</script>

<style>

</style>