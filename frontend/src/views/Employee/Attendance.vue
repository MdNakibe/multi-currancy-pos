<template>
    <v-container fluid>
        
        <v-row style="background: #fff;" class="theme_rounded mb-4" v-if="false">
            <v-col cols="auto" md="2">
                <v-row no-gutters style="margin-top: 3px;color: #000;" class="flex_align_center">
                    <v-col cols="3">Type</v-col>
                    <v-col cols="9">
                        <v-combobox 
                            v-model="filterData.searchType"
                            dense
                            outlined
                            hide-details
                            :items="['All', 'Checkin', 'Checkout']"
                        >
                        </v-combobox>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="auto" md="3">
                <v-row no-gutters style="margin-top: 3px;color: #000;" class="flex_align_center">
                    <v-col cols="4">Employee</v-col>
                    <v-col cols="8">
                        <v-combobox 
                            dense
                            outlined
                            hide-details
                            v-model="employee"
                            @focus="$store.dispatch('employee/getEmployees')"
                            :items="$store.getters['employee/employees']"
                            item-text="display_text"
                            item-value="id"
                        >
                        </v-combobox>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="auto" md="4">
                <v-row no-gutters style="margin-top: 3px;color: #000;" class="flex_align_center">
                    <v-col cols="4">Date</v-col>
                    <v-col cols="8">
                        <v-menu
                            v-model="monthMenue"
                            :close-on-content-click="false"
                            :nudge-right="0"
                            transition="scale-transition"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    dense
                                    outlined
                                    hide-details
                                    v-model="filterData.date_from"
                                    v-bind="attrs"
                                    v-on="on"
                                    label="From Date"
                                    autocomplete="off"
                                >
                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                </v-text-field>
                            </template>
                            <v-date-picker
                                v-model="filterData.date_from"
                                @input="monthMenue = false"
                            >
                            </v-date-picker>
                        </v-menu>
                        <v-menu
                            v-model="monthMenueTo"
                            :close-on-content-click="false"
                            :nudge-right="0"
                            transition="scale-transition"
                            style="margin-top: 10px;display: block;"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    dense
                                    outlined
                                    hide-details
                                    v-model="filterData.date_to"
                                    v-bind="attrs"
                                    v-on="on"
                                    label="To Date"
                                    autocomplete="off"
                                >
                                    <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                </v-text-field>
                            </template>
                            <v-date-picker
                                v-model="filterData.date_to"
                                @input="monthMenueTo = false"
                            >
                            </v-date-picker>
                        </v-menu>
                    </v-col>
                </v-row>
            </v-col>
            <v-col>
                <v-btn @click="handleSearch" color="green" dark>Search</v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" class="pb-0 shadow1 white theme_rounded">
                <v-data-table
                    class="custom-data-table"
                    :headers="departmentHeaders"
                    :search="searchDepartment"
                    :items="$store.getters['attendance/attendances']"
                    :loading="$store.getters['attendance/loadingAttendance']" 
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
                                >Attendance List</v-toolbar-title
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
    name: 'Attendance',

    components: {
		"confirm-dialog": confirmDialog,
		"department-dialog": departmentDialog,
	},

    data: () => ({
        departmentHeaders: [
            { text: 'SL', value: 'sl' },
            { text: 'Employee id', value: 'employee.emp_id' },
            { text: 'Name', value: 'employee.name' },
            { text: 'Type', value: 'type' },
            { text: 'Clock in', value: 'clock_in' },
            { text: 'Clock out', value: 'clock_out' },
            { text: 'Duration in minutes', value: 'duration' },
            // { text: 'Action', value: 'action' },
        ],
        filterData: {
            searchType: 'All',
            employee_id: null,
            date_from: null,
            date_to: null,
        },
        monthMenue: false,
        monthMenueTo: false,
        searchDepartment: "",
        departmentId: null,
        employee: null,
        loading: false,
        userType: ''

    }),

    watch: {
        employee(employee) {
            if (employee) {
                this.filterData.employee_id = employee.id
            }
        },
    },
    
    async created() {
        await this.$store.dispatch("attendance/getAttendance");
        let userData = JSON.parse(localStorage.getItem('userData'));
		this.userType = userData.userType;
    },

    methods: {
        async handleSearch() {
            // console.log(this.filterData);
            console.log(this.filterData);
            await this.$store.dispatch("attendance/getAttendance", {
                date: this.filterData.date,
                searchType: this.filterData.searchType,
                employee_id: this.filterData.employee_id,
            });
        },
        
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