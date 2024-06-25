<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Traits\FileTrait;

class ProductController extends Controller
{
    use FileTrait;

    private $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function GetProducts(Request $req)
    {
        $products = $this->productRepo->Get($req->all());
        return response()->json(['products' => $products], 200);
    }

    public function AddProduct(Request $req)
    {
        $pdt = json_decode($req->product, true);
        // return response(['barcode'], 500);
        
        $product = new Product();

        $productKeys = ['name', 'code', 'category_id', 'brand_id', 'image', 'unit_id', 'barcode'];
        foreach($productKeys as $key) {
            $product->$key = $pdt[$key];
        }

        if ($req->hasFile('image')) {
            $img = $req->file('image');
            $name = $img->hashName();
            $path = $img->move('products', $name);
            $product->image = '/products/'.$name;
            $product->image = '/'.$path;
            $res = $this->uploadFile($img);
            if ($res->status) {
                $product->image = $res->path;
            }
        }
        $res = $this->productRepo->Insert($product);
        return response()->json(['message' => $res->message], $res->code);
    }
    public function bulkImportProduct(Request $req)
    {
        if ($req->products && count($req->all())) {
            $res = $this->productRepo->bulkImportProduct($req->all());
            return response()->json(['message' => $res], 200);
        }

        return response()->json(['message' => 'There is some issue with data.'], 500);
    }
    public function bulkImportPurchase(Request $req)
    {
        if ($req->products && count($req->all())) {
            $res = $this->productRepo->bulkImportPurchase($req->all());
            return response()->json(['message' => $res], 200);
        }

        return response()->json(['message' => 'There is some issue with data.'], 500);
    }

    public function UpdateProduct(Request $req)
    {
        $pdt = json_decode($req->product, true);

        $product = $this->productRepo->GetById($pdt['id']);

        // return response($pdt, 500);
        $productKeys = ['name', 'code', 'description', 'category_id', 'image', 'brand_id', 'unit_id', 'purchase_rate', 'sale_rate', 'wholesale_rate', 'low_stock_qty', 'barcode'];
        foreach($productKeys as $key) {
            $product->$key = $pdt[$key];
        }
        // return response($product, 500);

        if ($req->hasFile('image')) {
            $old_img = $product->image;
            $img = $req->file('image');
            $name = $img->hashName();
            // $img->move(public_path('products'), $name);
            $path = $img->move('products', $name);
            // $product->image = '/products/'.$name;
            $product->image = '/'.$path;
            if ($old_img && file_exists(public_path($old_img))) {
                unlink(public_path($old_img));
            }
        } 
        // elseif($req->removeImg) {
        //     try {
        //         if ($product->image) {
        //             $this->deleteFile($product->image);
        //         }
        //     } catch (\Throwable $th) {}
        // }

        $res = $this->productRepo->Update($product);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function DeleteProduct($id)
    {
        $res = $this->productRepo->Delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function GenerateProductCode()
    {
        $code = $this->productRepo->GenerateProductCode();
        return response()->json(['code' => $code], 200);
    }

    public function lowStockProducts(Request $request) {
        $products = $this->productRepo->lowStockProducts($request->all());
        return response()->json(['products' => $products], 200);

    }

    public function GetCurrentStock(Request $req)
    {
        $stock = $this->productRepo->GetCurrentStock($req->all());
        return response()->json(['stock' => $stock], 200);
    }

    public function GetTotalStock(Request $req)
    {
        $stock = $this->productRepo->GetTotalStock($req->all());
        return response()->json(['stock' => $stock], 200);
    }

    public function GetProductLeder(Request $req)
    {
        $res = $this->productRepo->Ledger($req->all());
        return response()->json(['ledgers'  => $res->ledgers, 'openingStock' => $res->openingStock], 200);
    }
    public function getStocksHistory(Request $request)
    {
        $res = $this->productRepo->getStocksHistory($request->all());
        return response()->json(['stockhistory'  => $res], 200);
    }
    public function stockUpdate(Request $request)
    {
        $res = $this->productRepo->stockUpdate($request->all());
        return response()->json(['message'  => $res], 200);
    }
}
