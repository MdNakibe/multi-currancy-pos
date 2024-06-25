<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\BankAccount;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Month;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
        /**
     * Seed the application's database.
     *
     * @return void
     */
    public $branches = array(
        array('name' => 'Main Branch','title' => '','address' => 'Dhaka, Bangladesh','image' => NULL,'added_by' => NULL,'updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-12 21:23:57','updated_at' => '2022-11-12 21:23:57'),
        array('name' => 'Dhaka Branch','title' => 'Dhaka Branch','address' => 'Mirpur-6 dhaka','image' => '','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-12-20 06:00:05','updated_at' => '2022-12-20 06:00:05')
    );
    public $brands = array(
        array('id' => '1','name' => 'Motul','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:51:12','updated_at' => '2022-11-13 16:51:12'),
        array('id' => '2','name' => 'XPS','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:51:39','updated_at' => '2022-11-13 16:51:39'),
        array('id' => '3','name' => 'MT','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:53:47','updated_at' => '2022-11-13 16:53:47'),
        array('id' => '4','name' => 'Axor','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:55:03','updated_at' => '2022-11-13 16:55:03'),
        array('id' => '5','name' => 'Preelee','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:56:18','updated_at' => '2022-11-13 16:56:18'),
        array('id' => '6','name' => 'Quickfix','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 17:01:03','updated_at' => '2022-11-13 17:01:03'),
        array('id' => '7','name' => 'iPhone','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-12-07 17:15:52','updated_at' => '2022-12-07 17:15:52'),
        array('id' => '8','name' => 'Apple','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-12-07 17:15:59','updated_at' => '2022-12-07 17:15:59'),
        array('id' => '9','name' => 'Oppo','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-12-07 17:16:03','updated_at' => '2022-12-07 17:16:03'),
        array('id' => '10','name' => 'Samsung','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-12-07 17:16:07','updated_at' => '2022-12-07 17:16:07')
    );

    public $areas = array(
        array('id' => '1','name' => 'Dhaka','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 16:36:21','updated_at' => '2022-11-13 16:36:21'),
        array('id' => '2','name' => 'Rampura','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 17:29:36','updated_at' => '2022-11-13 17:29:36'),
        array('id' => '3','name' => 'Uttara','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 17:30:39','updated_at' => '2022-11-13 17:30:39'),
        array('id' => '4','name' => 'Cumilla','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:21:19','updated_at' => '2022-11-20 16:21:19')
    );
    public $bank_accounts = array(
        array('id' => '1','account_name' => 'Default account','account_number' => '2020556569882','account_type' => 'Business','bank_name' => 'Standard Chatard Bank','branch_name' => 'Gulshan Branch','initial_balance' => '0.00','description' => NULL,'status' => '1','branch_id' => '1','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-14 00:21:45','updated_at' => '2022-11-14 00:21:45')
    );
    public $categories = array(
        array('id' => '1','name' => 'Mobil','description' => 'All kinds of motorcycle mobil','branch_id' => '1','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 16:49:10','updated_at' => '2022-11-13 16:49:10'),
        array('id' => '2','name' => 'Tyre','description' => 'All kinds of tire','branch_id' => '1','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 16:49:28','updated_at' => '2022-11-13 16:49:28'),
        array('id' => '3','name' => 'Helmet','description' => 'All kinds of helmet','branch_id' => '1','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 16:49:41','updated_at' => '2022-11-13 16:49:41'),
        array('id' => '4','name' => 'Windbreaker','description' => 'All kinds of Windbreaker','branch_id' => '1','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 16:49:56','updated_at' => '2022-11-13 16:49:56'),
        array('id' => '5','name' => 'Acessories','description' => 'All kinds of Motorcycle Acessories','branch_id' => '1','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 17:00:04','updated_at' => '2022-11-13 17:00:04'),
        array('id' => '6','name' => 'Mobile Phone','description' => 'Iphone','branch_id' => '1','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-12-07 17:15:35','updated_at' => '2022-12-07 17:15:35')
    );
    public $company_profiles = array(
        array('id' => '1','company_name' => 'Motocyte','address' => 'Ka/32/5/A, Palash Tower (Ground Floor, Dhaka 1212)','contact_us' => '01835006633','email' => 'info@bikersocen.com','image' => 'images/ca58205c-27f3-4612-957f-3b6286f1a050.png','type' => '3','point' => '0.00','rate' => '0.00','updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-01-02 10:04:44')
    );
    public $customers = array(
        array('id' => '1','code' => 'C00001','name' => 'Rushdan Auto','phone' => '01988552566','email' => 'Rushdanauto@gmail.com','area_id' => '2','address' => 'Rampura Dhaka','org_name' => 'Rushdan Auto','org_phone' => '2156512','type' => '','credit_limit' => '100000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 17:30:15','updated_at' => '2022-11-13 17:30:15'),
        array('id' => '2','code' => 'C00002','name' => 'Auto King','phone' => '01895222335','email' => 'autokinguttara@gmail.com','area_id' => '3','address' => 'Uttara, Dhaka, Bangladesh','org_name' => 'Auto king Uttara','org_phone' => '0255656','type' => '','credit_limit' => '100000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 17:31:18','updated_at' => '2022-11-13 17:31:18'),
        array('id' => '3','code' => 'C00003','name' => 'Raida Trade Int','phone' => '01787034556','email' => 'dsedea@gmail.com','area_id' => '2','address' => 'FAnjnfgvjn','org_name' => 'Raida Trade Int','org_phone' => NULL,'type' => 'Wholesale','credit_limit' => '100000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-27 16:20:18','updated_at' => '2022-11-27 16:20:18'),
        array('id' => '4','code' => 'C00004','name' => 'Gadget N phone','phone' => '01717038999','email' => 'gfhfgh@gmailvnjg.vim','area_id' => '2','address' => 'GDgfdhfh','org_name' => 'GNP','org_phone' => NULL,'type' => 'Wholesale','credit_limit' => '100000000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-12-07 17:14:20','updated_at' => '2022-12-07 17:14:20')
    );
    public $departments = array(
        array('id' => '1','name' => 'Sales','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 17:04:33','updated_at' => '2022-11-13 17:04:33'),
        array('id' => '2','name' => 'Operation','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 17:04:42','updated_at' => '2022-11-13 17:04:42'),
        array('id' => '3','name' => 'Marketing','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 17:04:52','updated_at' => '2022-11-13 17:04:52'),
        array('id' => '4','name' => 'It','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 17:04:58','updated_at' => '2022-11-13 17:04:58')
    );
    public $designations = array(
        array('id' => '1','name' => 'Operation Manager','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 17:05:11','updated_at' => '2022-11-13 17:05:11'),
        array('id' => '2','name' => 'Sales Executive','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 17:05:24','updated_at' => '2022-11-13 17:05:24'),
        array('id' => '3','name' => 'Marketing Officer','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 17:05:37','updated_at' => '2022-11-13 17:05:37'),
        array('id' => '4','name' => 'Sales Manager','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:13:26','updated_at' => '2022-11-20 16:13:26')
    );
    public $employees = array(
        array('id' => '1','emp_id' => 'E00001','name' => 'Md Abdur Rahman Babu','father_name' => '','mother_name' => '','spouse_name' => 'Vabi','gender' => 'Male','birth_date' => '1988-05-10','nid' => '26222962992','blood_group' => 'A+','religion' => 'Islam','nationality' => 'Bangladeshi','marital_status' => 'Married','present_address' => '','permanent_address' => '','country' => NULL,'phone' => '01886555233','email' => 'babu@bikersocean.com','joining_date' => '2022-10-01','image' => 'images/employee/e0331aae-602d-47e3-b642-acb557be2b7c.jpg','signature_image' => '','nominee_name' => NULL,'nominee_image' => '','area_id' => '1','designation_id' => '1','department_id' => '2','salary' => '0.00','status' => 'a','added_by' => NULL,'updated_by' => '1','branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 17:06:41','updated_at' => '2022-12-20 22:22:39'),
        array('id' => '2','emp_id' => 'E00002','name' => 'Shuvo','father_name' => 'Afsdfdd','mother_name' => 'fgfgfgfg','spouse_name' => '','gender' => 'Male','birth_date' => '1993-11-17','nid' => '254511651581','blood_group' => 'B+','religion' => 'Islam','nationality' => 'Pakistan','marital_status' => 'Single','present_address' => 'Gulashan Dhaka','permanent_address' => 'Gulashan Dhaka','country' => 'Bangladesh','phone' => '0189262623','email' => 'shuvo@bikersocean.com','joining_date' => '2022-08-04','image' => 'a89c7b44-f34f-48c1-894a-e25962c64c87.png','signature_image' => '','nominee_name' => NULL,'nominee_image' => '','area_id' => '1','designation_id' => '2','department_id' => '1','salary' => '0.00','status' => 'a','added_by' => NULL,'updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 17:08:47','updated_at' => '2022-11-13 17:08:47')
    );
    public $months = array(
        array('id' => '1','name' => 'January','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:14:27','updated_at' => '2022-11-20 16:14:27'),
        array('id' => '2','name' => 'February','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:14:38','updated_at' => '2022-11-20 16:14:38'),
        array('id' => '3','name' => 'March','added_by' => '1','updated_by' => NULL,'deleted_at' => '2022-11-20 16:15:18','created_at' => '2022-11-20 16:14:56','updated_at' => '2022-11-20 16:15:18'),
        array('id' => '4','name' => 'April','added_by' => '1','updated_by' => NULL,'deleted_at' => '2022-11-20 16:16:00','created_at' => '2022-11-20 16:15:02','updated_at' => '2022-11-20 16:16:00'),
        array('id' => '5','name' => 'May','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:16:22','updated_at' => '2022-11-20 16:16:22'),
        array('id' => '6','name' => 'June','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:16:29','updated_at' => '2022-11-20 16:16:29'),
        array('id' => '7','name' => 'July','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:16:38','updated_at' => '2022-11-20 16:16:38'),
        array('id' => '8','name' => 'August','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:16:45','updated_at' => '2022-11-20 16:16:45'),
        array('id' => '9','name' => 'September','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:16:52','updated_at' => '2022-11-20 16:16:52'),
        array('id' => '10','name' => 'October','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:17:00','updated_at' => '2022-11-20 16:17:00'),
        array('id' => '11','name' => 'November','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:17:06','updated_at' => '2022-11-20 16:17:06'),
        array('id' => '12','name' => 'December','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-20 16:17:12','updated_at' => '2022-11-20 16:17:12')
    );
    public $suppliers = array(
        array('id' => '1','code' => 'S00001','name' => 'Motul','phone' => '01917887889','email' => 'motul@gmail.com','area_id' => '1','address' => 'Gendaria, Bongshal, Dhaka','org_name' => 'Motul Bangladesh Ltd.','org_phone' => '25889200','credit_limit' => '20000000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:40:56','updated_at' => '2022-11-13 16:40:56'),
        array('id' => '2','code' => 'S00002','name' => 'Xps Mobil','phone' => '01863368996','email' => 'liteniumbd@gmail.com','area_id' => '1','address' => 'West Rampura Dhaka','org_name' => 'Liteniam Bangladesh','org_phone' => '88988282','credit_limit' => '1000000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:42:19','updated_at' => '2022-11-13 16:42:19'),
        array('id' => '3','code' => 'S00003','name' => 'Axor Helmet','phone' => '01977498665','email' => 'vulcanlifestyle@gmail.com','area_id' => '1','address' => 'Iskaton road, Dhaka','org_name' => 'Vulcan Lifestyle','org_phone' => '0255518','credit_limit' => '5000000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:44:23','updated_at' => '2022-11-13 16:44:23'),
        array('id' => '4','code' => 'S00004','name' => 'Mt Helmet','phone' => '01589635663','email' => 'mthelmetbd@gmail.com','area_id' => '1','address' => 'Panthapath Dhaka','org_name' => 'Mt Helmet Banglaesh','org_phone' => '50555562','credit_limit' => '50000000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:45:30','updated_at' => '2022-11-13 16:45:30'),
        array('id' => '5','code' => 'S00005','name' => 'Bongshal Acessories','phone' => '01655565263','email' => 'kohinurmotors@gmail.com','area_id' => '1','address' => 'Bongshal dhaka','org_name' => 'Kohinur Motors','org_phone' => '78888151','credit_limit' => '2000000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:47:06','updated_at' => '2022-11-13 16:47:06'),
        array('id' => '6','code' => 'S00006','name' => 'Preelee Tire','phone' => '01462251513','email' => 'preelee@gmail.com','area_id' => '1','address' => 'Gudaraghat Dhaka Bangladesh','org_name' => 'Preelee','org_phone' => '516651561','credit_limit' => '5000000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:48:10','updated_at' => '2022-11-13 16:48:10'),
        array('id' => '7','code' => 'S00007','name' => 'Quickfix','phone' => '01899936599','email' => 'sales@quickfixglobal.com','area_id' => '1','address' => 'Gulshan Dhaka','org_name' => 'Quickfix Global','org_phone' => '0288858','credit_limit' => '5000000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-11-13 16:59:09','updated_at' => '2022-11-13 16:59:09'),
        array('id' => '8','code' => 'S00008','name' => 'Sobuj Telecom','phone' => '01937664266','email' => NULL,'area_id' => '1','address' => 'Gulshan 2','org_name' => 'Ibox','org_phone' => NULL,'credit_limit' => '10000000.00','added_by' => '1','updated_by' => NULL,'branch_id' => '1','deleted_at' => NULL,'created_at' => '2022-12-07 17:13:35','updated_at' => '2022-12-07 17:13:35')
    );
    public $units = array(
        array('id' => '1','name' => 'PCS','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 16:50:16','updated_at' => '2022-11-13 16:50:16'),
        array('id' => '2','name' => 'Cartun','added_by' => '1','updated_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-13 16:50:29','updated_at' => '2022-11-13 16:50:29')
    );
    public $users = [
        array('id' => '1','name' => 'Nasrullah','username' => 'admin','user_type' => 'super_admin','phone' => '01796953487','email' => 'jakirul.stu@gmail.com','password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','permissions' => NULL,'status' => '1','added_by' => NULL,'updated_by' => NULL,'branch_id' => '1','email_verified_at' => NULL,'remember_token' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-12 21:23:56','updated_at' => '2023-01-01 13:33:43'),
        array('id' => '2','name' => 'Jhon Doe','username' => 'user','user_type' => 'user','phone' => '01738722919','email' => 'azhar@gmail.com','password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','permissions' => '[{"name":"Sale Entry","link":"\\/sale","color":"blue","id":"nbpu5","icon":"mdi-cart"},{"name":"Sale Return","link":"\\/sale-return","color":"blue","id":"vba2e4","icon":"mdi-cart"}]','status' => '1','added_by' => '1','updated_by' => NULL,'branch_id' => '1','email_verified_at' => NULL,'remember_token' => NULL,'deleted_at' => NULL,'created_at' => '2022-11-28 03:05:18','updated_at' => '2022-11-28 03:06:50')
    ];
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::insert($this->users);
        Area::insert($this->areas);
        Branch::insert($this->branches);
        Brand::insert($this->brands);
        BankAccount::insert($this->bank_accounts);
        Category::insert($this->categories);
        CompanyProfile::insert($this->company_profiles);
        Customer::insert($this->customers);
        Department::insert($this->departments);
        Designation::insert($this->designations);
        Employee::insert($this->employees);
        Month::insert($this->months);
        Supplier::insert($this->suppliers);
        Unit::insert($this->units);
    }
}
