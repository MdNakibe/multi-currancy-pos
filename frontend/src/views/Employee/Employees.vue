<template>
    <v-container fluid>
        <v-row dense>
            <v-col cols="9">
                <v-form class="shadow1 white rounded mb-4 px-4 py-4">
                    <v-row dense class="align-center">
                        <v-col md="4">
                            <v-combobox
                                label="Department"
                                dense
                                outlined
                                hide-details
                                clearable
                                :items="$store.getters['department/departments']"
                                v-model="department"
                                item-text="name"
                                item-value="id"
                                :loading="$store.getters['department/loadingDepartments']"
                                @focus="$store.dispatch('department/getDepartments')"
                                class="custom-form"
                            ></v-combobox>
                        </v-col>
                        <v-col md="4">
                            <v-combobox
                                label="Designation"
                                dense
                                outlined
                                hide-details
                                clearable
                                :items="$store.getters['designation/designations']"
                                :loading="$store.getters['designation/loadingDesignations']"
                                @focus="$store.dispatch('designation/getDesignations')"
                                v-model="designation"
                                item-text="name"
                                item-value="id"
                                class="custom-form"
                            ></v-combobox>
                        </v-col>
                        <v-col md="4" class="d-flex items-center">
                            <v-btn class="text_bg_fave" @click="getEmployees">Search</v-btn>
                        </v-col>
                    </v-row>
                </v-form>

                <v-divider></v-divider>

                <v-row>
                    <v-col cols="12" class="pb-0 shadow1 white rounded py-4 px-4">
                        <v-data-table
                            class="custom-data-table"
                            :headers="employeeHeaders"
                            :search="employeeSearch"
                            :loading="$store.getters['employee/loadingEmployees']"
                            :items="$store.getters['employee/employees']"
                            @click:row="showDetails"
                        >
                            <template v-slot:top>
                                <v-toolbar dense color="white" :elevation="0">
                                    <v-toolbar-title class="subtitle-1">Employee List</v-toolbar-title>
                                    <v-divider class="mx-4" inset vertical></v-divider>
                                    <v-text-field
                                        outlined
                                        dense
                                        hide-details
                                        v-model="employeeSearch"
                                        placeholder="Search Employee"
                                        append-icon="mdi-magnify"
                                        style="max-width:300px;"
                                        class="custom-form"
                                    >
                                    </v-text-field>
                                </v-toolbar>
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </v-col>

            <v-col cols="3">
                <v-card
                    tile
                    max-width="375"
                    class="mx-auto"
                    height="100%"
                >
                    <v-card dark tile flat color="text_bg_fave">
                        <v-card-text class="text-center py-2">
                            <v-avatar color="green lighten-2" size="80" class="my-2">
                                <v-img contain :src="selectedEmployee.image"></v-img>
                            </v-avatar>

                            <h2 class="caption">{{ selectedEmployee.emp_id }}</h2>
                            <h1 class="subtitle-2">{{ selectedEmployee.name }}</h1>

                            <div>
                                <v-btn v-if="userType == 'super_admin' || userType == 'admin'" icon color="white" :disabled="selectedEmployee.id == null ? true : false" :to="{name: 'Employee', params: { id: selectedEmployee.id }}">
                                    <v-icon>mdi-account-edit</v-icon>
                                </v-btn>
                                <v-btn v-if="userType == 'super_admin' || userType == 'admin'" icon color="white" :disabled="selectedEmployee.id == null ? true : false" @click="employeeId = selectedEmployee.id;$refs.confirmDialog.dialog = true">
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                                <!-- <v-btn icon color="white" :disabled="selectedEmployee.id == null ? true : false" @click="employeeView(selectedEmployee)">
                                    <v-icon>mdi-printer</v-icon>
                                </v-btn> -->
                            </div>
                        </v-card-text>
                    </v-card>

                    <v-list dense>
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="gray">mdi-account-group</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedEmployee.department != null ? selectedEmployee.department.name : '' }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        
                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="gray">mdi-account-settings</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedEmployee.designation != null ? selectedEmployee.designation.name : '' }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        
                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="gray">mdi-card-account-details</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedEmployee.nid }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        
                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="gray">mdi-cellphone</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedEmployee.phone }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        
                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="gray">mdi-email</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedEmployee.email }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        
                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="gray">mdi-map-marker</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedEmployee.address }}</v-list-item-title>
                                <v-list-item-subtitle>{{ selectedEmployee.area && selectedEmployee.area.name ? selectedEmployee.area.name : '' }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="gray">mdi-earth</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ selectedEmployee.country }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>

        <delete-confirm ref="confirmDialog" @confirm="deleteEmployee"></delete-confirm>
    </v-container>
</template>

<script>
import confirmDialog from '../../components/confirm-dialog.component.vue'

export default {
    name: 'Employees',

    components: {
        "delete-confirm": confirmDialog
    },

    data: () => ({
        department: null,
        designation: null,
        employeeSearch: '',
        employeeHeaders: [
            { text: 'Id', value: 'emp_id' },
            { text: 'Name', value: 'name' },
            { text: 'Department', value: 'department.name' },
            { text: 'Contact Address', value: 'present_address' },
            { text: 'Designation', value: 'designation.name' },
            { text: 'Phone', value: 'phone' },
            { text: 'Email', value: 'email' },
        ],
        selectedEmployee: {
            id: null,
            image: '',
            emp_id: 'E0001',
            name: 'Select an Employee',
            department: { name: 'Department' },
            designation: { name: 'Designation' },
            nid: 'NID',
            address: 'Employee\'s Address',
            country: 'Country',
            area: { name: 'Area' },
            phone: '01XXXXXXXXX',
            email: 'Employee\'s Email',
        },
        employeeId: null,
        userType: ''
    }),

    async created() {
        await this.getEmployees();
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;

    },

    methods: {
        async getEmployees() {
            let filter = {
                departmentId: this.department?.id,
                designationId: this.designation?.id
            }
            await this.$store.dispatch('employee/getEmployees', filter);
        },
        
        showDetails(employee) {
            this.selectedEmployee = employee;
            this.selectedEmployee.image = `${this.$store.state.hostName}/${employee.image}`
        },

        employeeView(employee){
            this.employeeViewDialog = true;
        },

        async deleteEmployee() {
            await this.$store.dispatch('employee/deleteEmployee', this.employeeId);
            this.$refs.confirmDialog.dialog = false;
        },
    }
}
</script>

<style lang="sass" scoped>

</style>>
