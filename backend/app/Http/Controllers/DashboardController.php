<?php

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use App\Repositories\BankRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SaleRepository;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private SupplierRepository $supplierRepository,
        private EmployeeRepository $employeeRepository,
        private SaleRepository $saleRepository,
        private AccountRepository $accountRepository,
        private BankRepository $bankRepository,
        private PurchaseRepository $purchaseRepository,
        private ProductRepository $productRepository,
    ){}
    public function GetDashboardData(Request $request) {
        $arg = $request->all();
        return response()->json([
            'customers' => $this->customerRepository->Get(),
            'customer_payments' => $this->customerRepository->GetPayments($arg),
            'suppliers' => $this->supplierRepository->Get($arg),
            'employees' => $this->employeeRepository->Get($arg),
            'supplier_due' => $this->supplierRepository->GetSupplierDue($arg),
            'supplier_payments' => $this->supplierRepository->GetPayments($arg),
            'balance' => $this->accountRepository->GetCashBalance($arg),
            'banks' => $this->bankRepository->GetBankBalance($arg),
            'graph_data' => $this->accountRepository->Ghrap(),
            'sales' => $this->saleRepository->Get($arg),
            'cash_transactions' => $this->accountRepository->GetTransaction($arg),
            'bank_transactions' => $this->bankRepository->GetTransaction($arg),
            'salary_payments' => $this->employeeRepository->GetPayments($arg),
            'purchases' => $this->purchaseRepository->Get($arg),
            'customer_due' => $this->customerRepository->GetCustomerDue($arg),
            'bank_account_balance' => $this->bankRepository->GetBankBalance(),
            'low_stock_products' => $this->productRepository->lowStockProducts($arg),
            'profit' => $this->accountRepository->ProfitLoss(),
        ]);
    }
}
