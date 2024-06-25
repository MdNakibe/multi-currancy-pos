<template>
    <v-container fluid>
        <v-form
            @submit.prevent="saveEmployeeInfo"
            ref="employeeInfoForm"
            class="custom-form"
        >
            <v-row dense>
                <v-col cols="12" md="3">
                    <v-card dark color="#26ab69" height="100%" class="shadow1_important rounded">
                        <v-card-text class="text-center pa-2">
                            <v-row>
                                <v-col cols="12">
                                    <div class="position-relative">
                                        <v-avatar color="white" size="110">
                                            <v-img v-if="employeeImagePreview" :src="employeeImagePreview"></v-img>
                                            <v-img v-else :src="avatar_default"></v-img>
                                        </v-avatar>
                                        <v-file-input
                                            class="employee-image-input"
                                            hide-input
                                            light
                                            truncate-length="15"
                                            accept=".png, .jpg"
                                            v-model="employeeImage"
                                        ></v-file-input>
                                    </div>
                                </v-col>
                                <v-col cols="12" class="pb-0">
                                    <h1 class="subtitle-2">{{ employee.name ? employee.name : "Employee Name" }}</h1>
                                    <p class="caption mb-0">
                                        {{ selectedDesignation ? selectedDesignation.name : "Designation" }}{{ selectedDepartment ? `, ${selectedDepartment.name}` : ", Department" }}
                                    </p>
                                    <p class="caption mb-0">
                                        {{ employee.phone ? employee.phone : "Phone Number" }}
                                    </p>
                                </v-col>
                            </v-row>
                        </v-card-text>

                        <v-card-actions>
                            <v-row dense>
                                <v-col cols="6" class="pb-0">
                                    <v-btn
                                        width="100%"
                                        color="yellow darken-3"
                                        class="text-none mb-2"
                                        @click="$refs.signatureInput.click()"
                                    >Signature</v-btn>
                                    <input
                                        ref="signatureInput"
                                        class="d-none"
                                        type="file"
                                        accept=".png, .jpg"
                                        @change="signatureImage = $event.target.files[0]"
                                    >
                                    <v-dialog v-model="signatureDialog" persistent max-width="500">
                                        <template v-slot:activator="{ on }">
                                            <v-btn
                                                width="100%"
                                                color="light-blue"
                                                v-on="on"
                                            >View</v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>Signature Image</v-card-title>

                                            <v-card-text>
                                                <v-img :src="signatureImagePreview" v-if="signatureImagePreview"></v-img>
                                                <span v-else class="caption">No image chosen</span>
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    dense
                                                    color="error"
                                                    text
                                                    @click="signatureDialog = false"
                                                >Close</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-col>
                                <v-col cols="6" class="pb-0">
                                    <v-btn
                                        width="100%"
                                        color="yellow darken-3"
                                        class="text-none mb-2"
                                        @click="$refs.nomineeImageInput.click()"
                                    >Nominee Img</v-btn>
                                    <input
                                        ref="nomineeImageInput"
                                        class="d-none"
                                        type="file"
                                        accept=".png, .jpg"
                                        @change="nomineeImage = $event.target.files[0]"
                                    >
                                    <v-dialog v-model="nomineeImageDialog" persistent max-width="500">
                                        <template v-slot:activator="{ on }">
                                            <v-btn
                                                width="100%"
                                                color="light-blue"
                                                v-on="on"
                                            >View</v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>Nominee Image</v-card-title>

                                            <v-card-text>
                                                <v-img :src="nomineeImagePreview" v-if="nomineeImagePreview"></v-img>
                                                <span v-else class="caption">No image chosen</span>
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    dense
                                                    color="error"
                                                    text
                                                    @click="nomineeImageDialog = false"
                                                >Close</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-col>
                            </v-row>
                        </v-card-actions>
                    </v-card>
                </v-col>

                <v-col cols="12" md="9">
                    <v-card height="100%" class="shadow1 white rounded">
                        <v-toolbar color="white" :elevation="0">
                            <v-toolbar-title class="subtitle-1">Personal Information</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text class="py-0">
                            <v-row>
                                <v-col cols="12" md="6">
                                     <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Employee ID</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model="employee.emp_id"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Full Name <span style="color: red;">*</span></v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model.trim="employee.name"
                                                :rules="[(v) => !!v]"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Father's Name</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model.trim="employee.father_name"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Mother's Name</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model.trim="employee.mother_name"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Contact Address</v-col>
                                        <v-col cols="8" class="py-0 pb-1">
                                            <v-textarea
                                                outlined
                                                hide-details
                                                :rows="2"
                                                v-model.trim="employee.present_address"
                                            ></v-textarea>
                                        </v-col>
                                    </v-row>
                                    <!-- <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Nomiee Name</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model.trim="employee.nominee_name"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Permanent Address</v-col>
                                        <v-col cols="8" class="py-0 pb-1">
                                            <v-textarea
                                                outlined
                                                hide-details
                                                :rows="2"
                                                v-model.trim="employee.permanent_address"
                                            ></v-textarea>
                                        </v-col>
                                    </v-row>
                                     -->
                                <!--
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Area</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-combobox
                                                dense
                                                outlined
                                                hide-details
                                                item-text="name"
                                                item-value="id"
                                                @focus="$store.dispatch('area/getAreas')"
                                                :loading="$store.getters['area/loadingAreas']"
                                                :items="$store.getters['area/areas']"
                                                v-model="selectedArea"
                                            ></v-combobox>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Country</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-combobox
                                                dense
                                                outlined
                                                hide-details
                                                :items="$store.getters['countries']"
                                                v-model="employee.country"
                                            ></v-combobox>
                                        </v-col>
                                    </v-row> -->
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Contact Number <span style="color: red;">*</span></v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                :rules="[(v) => !!v]"
                                                v-model.trim="employee.phone"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                     <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Joining Date <span style="color: red;">*</span></v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-menu
                                                v-model="joining_date_menu"
                                                :close-on-content-click="false"
                                                :nudge-right="0"
                                                transition="scale-transition"
                                                offset-y
                                                min-width="auto"
                                            >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="employee.joining_date"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        :rules="[(v) => !!v]"
                                                        autocomplete="off"
                                                    >
                                                        <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker
                                                    v-model="employee.joining_date"
                                                    @input="joining_date_menu = false"
                                                >
                                                </v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Email</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model.trim="employee.email"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Gender <span style="color: red;">*</span></v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-select
                                                dense
                                                outlined
                                                hide-details
                                                :items="['Male', 'Female']"
                                                :rules="[(v) => !!v]"
                                                v-model="employee.gender"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Date of Birth</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-menu
                                                v-model="birth_date_menu"
                                                :close-on-content-click="false"
                                                :nudge-right="0"
                                                transition="scale-transition"
                                                offset-y
                                                min-width="auto"
                                            >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model="employee.birth_date"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        autocomplete="off"
                                                    >
                                                        <v-icon slot="prepend-inner">mdi-calendar-month</v-icon>
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker
                                                    v-model="employee.birth_date"
                                                    @input="birth_date_menu = false"
                                                >
                                                </v-date-picker>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Blood Group</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-select
                                                dense
                                                outlined
                                                hide-details
                                                :items="['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']"
                                                v-model="employee.blood_group"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                    <!-- <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Marital Status</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-select
                                                dense
                                                outlined
                                                hide-details
                                                :items="['Single', 'Married', 'Divorced', 'Widowed']"
                                                v-model="employee.marital_status"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row v-if="employee.marital_status == 'Married'">
                                        <v-col cols="4" class="py-1 pr-1 caption">Spouse Name</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model.trim="employee.spouse_name"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption" >Religion</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-select
                                                dense
                                                outlined
                                                hide-details
                                                :items="['Islam', 'Hinduism', 'Buddhism', 'Christianity', 'Other']"
                                                v-model="employee.religion"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Nationality</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model.trim="employee.nationality"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row> -->
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Photo ID Number</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model.trim="employee.nid"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Department <span style="color: red;">*</span></v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-combobox
                                                dense
                                                outlined
                                                hide-details
                                                item-text="name"
                                                item-value="id"
                                                @focus="$store.dispatch('department/getDepartments')"
                                                :items="$store.getters['department/departments']"
                                                :loading="$store.getters['department/loadingDepartments']"
                                                :rules="[(v) => !!v]"
                                                v-model="selectedDepartment"
                                            ></v-combobox>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Designation <span style="color: red;">*</span></v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-combobox
                                                dense
                                                outlined
                                                hide-details
                                                item-text="name"
                                                item-value="id"
                                                @focus="$store.dispatch('designation/getDesignations')"
                                                :items="$store.getters['designation/designations']"
                                                :loading="$store.getters['designation/loadingDesignations']"
                                                :rules="[(v) => !!v]"
                                                v-model="selectedDesignation"
                                            ></v-combobox>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Salary <span style="color: red;">*</span></v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                :rules="[(v) => !!v]"
                                                v-model.trim="employee.salary"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Commission Rate</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model.trim="employee.commission_rate"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4" class="py-1 pr-1 caption">Discount Percent Limit</v-col>
                                        <v-col cols="8" class="py-0">
                                            <v-text-field
                                                dense
                                                outlined
                                                hide-details
                                                v-model.trim="employee.discount_limit"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" md="12" class="text-right">
                                            <v-btn
                                                height="30px"
                                                width="120"
                                                dark
                                                color="text_bg_fave mr-1"
                                                :elevation="1"
                                                type="submit"
                                                :loading="loading"
                                            >Save</v-btn>
                                            <v-btn
                                                width="120"
                                                @click="resetEmployeeForm"
                                                height="30px"
                                                dark
                                                color="deep-orange"
                                                :elevation="1"
                                            >Cancel</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            
        </v-form>
    </v-container>
</template>

<script>
import avatar_default from '../../assets/avatar_default.jpg'
export default {
    name: 'Employee',
    
    data: () => {
        return {
            avatar_default: avatar_default,
            joining_date_menu: false,
            birth_date_menu: false,
            employee: {
                id: null,
                emp_id: null,
                name: null,
                father_name: null,
                mother_name: null,
                nominee_name: null,
                present_address: null,
                permanent_address: null,
                area_id: null,
                country: null,
                phone: null,
                email: null,
                gender: null,
                birth_date: null,
                blood_group: null,
                marital_status: null,
                spouse_name: null,
                religion: null,
                nationality: null,
                nid: null,
                department_id: null,
                designation_id: null,
                joining_date: null,
                salary: 0,
                commission_rate: 0,
                discount_limit: 0
            },
            selectedArea: null,
            selectedDepartment: null,
            selectedDesignation: null,
           
        
            employeeImage: null,
            signatureImage: null,
            signatureDialog: false,
            nomineeImage: null,
            nomineeImageDialog: false,

            employeeImagePreview: null,
            signatureImagePreview: null,
            nomineeImagePreview: null,

            loading: false,
        };
    },

    watch: {
        selectedArea(area) {
            if (area == null) return;
            this.employee.area_id = area.id;
        },
        selectedDepartment(department) {
            if (department == null) return;
            this.employee.department_id = department.id;
        },
        selectedDesignation(designation) {
            if (designation == null) return;
            this.employee.designation_id = designation.id;
        },
        selectedReportingBoss(reporting_boss) {
            if (reporting_boss == null) return;
            this.employee.reporting_boss_id = reporting_boss.id;
        },
        selectedBank(bank) {
            if (bank == null) return;
            this.employee.bank_name = bank.name;
        },
        employeeImage(image) {
            if (image == null) {
                this.employeeImagePreview = null;
            } else {
                this.employeeImagePreview = URL.createObjectURL(this.employeeImage);
            }
        },
        signatureImage(image) {
            if (image == null) {
                this.signatureImagePreview = null;
            } else {
                this.signatureImagePreview = URL.createObjectURL(this.signatureImage);
            }
        },
        nomineeImage(image) {
            if (image == null) {
                this.nomineeImagePreview = null;
            } else {
                this.nomineeImagePreview = URL.createObjectURL(this.nomineeImage);
            }
        },
    },

    async created() {
        if(this.$route.params.id) {
            await this.getEmployee();
        } else {
            await this.$store.dispatch("employee/generateEmployeeCode");
            this.employee.emp_id = this.$store.getters["employee/code"];
        }
    },

    methods: {
        async saveEmployeeInfo() {
            if (!this.$refs.employeeInfoForm.validate()) return;

            this.loading = true;

            let isSuccess = await this.$store.dispatch("employee/saveEmployee", {
                employee: this.employee,
                image: this.employeeImage,
                signature: this.signatureImage,
                nominee: this.nomineeImage,
            });

            this.loading = false;

            if(isSuccess) {
                this.$router.push('/employee')
                this.resetEmployeeForm();
            }
        },

        async resetEmployeeForm() {
            Object.keys(this.employee).forEach((k) => {
                if (typeof this.employee[k] == "string") {
                    this.employee[k] = "";
                } else if (typeof this.employee[k] == "number") {
                    this.employee[k] = 0;
                } else if (typeof this.employee[k] == "boolean") {
                    this.employee[k] = false;
                }
            });

            this.selectedArea = this.selectedDepartment = this.selectedDesignation = null;
            this.selectedReportingBoss = this.selectedBank = this.selectedDocumentImage = null;
            this.employeeImagePreview = this.signatureImagePreview = this.nomineeImagePreview = null;
            this.employeeImage = this.signatureImage = this.nomineeImage = null;

            await this.$store.dispatch("employee/generateEmployeeCode");
            this.employee.emp_id = this.$store.getters["employee/code"];

            this.$refs.employeeInfoForm.resetValidation();
        },


        async getEmployee() {
            await this.$store.dispatch('employee/getEmployees', {id: this.$route.params.id});

            let employee = await this.$store.getters['employee/employees'][0];

            Object.keys(this.employee).forEach(key => this.employee[key] = employee[key]);
            this.selectedArea = employee.area,
            this.selectedDepartment = employee.department,
            this.selectedDesignation = employee.designation,

            this.employeeImagePreview = `${this.$store.state.hostName}/${employee.image}`
            this.signatureImagePreview = `${this.$store.state.hostName}/${employee.image}`;
            this.nomineeImagePreview = `${this.$store.state.hostName}/${employee.image}`;
        }
    },
};
</script>

<style lang="scss" scoped>
.v-data-table {
    td {
        font-size: 12px !important;
    }
}
.position-relative {
    position: relative;
    
}
.employee-image-input {
    position: absolute;
    // bottom: -15px;
    // left: 45%;
    width: 115px;
    height: 115px;
    border-radius: 50%;
    background: rgba(0,0,0,0);
    display: flex;
    justify-content: center;
    align-items: center;
    top: -6px;
    left: 50%;
    border: 2px solid #ddd;
    transform: translateX(-50%);
    display: none;
    &:hover {
        background: rgba(0,0,0,0.5);
    }
}
.position-relative .v-avatar:hover + .employee-image-input,
.employee-image-input:hover {
    display: flex;
    background: rgba(0,0,0,0.5);
}
.v-input__prepend-outer {
    background: #fff;
}
.image-input {
    position: absolute;
    bottom: -15px;
    left: 40%;
}
.no-image {
    border: 1px solid #fff;
    padding: 8px 0;
    font-style: italic;
    color: #fff;
    margin: 0 5px;
}
</style>
