<template>
    <v-container fluid>
        <v-row dense justify="center">
            <v-col cols="9">
                <v-row no-gutters>
                    <v-col cols="12">
                        <v-btn height="26px" @click.prevent="print" class="mb-2">Print</v-btn>
                    </v-col>
                </v-row>

                <div id="invoiceContent">
                    <v-row no-gutters>
                        <v-col cols="12">
                            <div class="invoice-title"> Purchase Return Invoice </div>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col cols="7">
                            <table class="table">
                                <tr>
                                    <td>Supplier Id</td>
                                    <td style="padding:1px 5px">:</td>
                                    <td>{{ purchaseReturn.purchase ? purchaseReturn.purchase.supplier.code : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Supplier Name</td>
                                    <td style="padding:1px 5px">:</td>
                                    <td>{{ purchaseReturn.purchase ? purchaseReturn.purchase.supplier.name : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Mobile</td>
                                    <td style="padding:1px 5px">:</td>
                                    <td>{{ purchaseReturn.purchase ? purchaseReturn.purchase.supplier.phone : ''}}</td>
                                </tr>
                            </table>
                        </v-col>
                        <v-col cols="5">
                            <table class="table" style="float:right">
                                <tr>
                                    <td>Invoice No</td>
                                    <td style="padding:1px 5px">:</td>
                                    <td>{{ purchaseReturn ? purchaseReturn.invoice : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Purchase Date</td>
                                    <td style="padding:1px 5px">:</td>
                                    <td>{{ purchaseReturn.purchase ? purchaseReturn.purchase.date : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Return Date</td>
                                    <td style="padding:1px 5px">:</td>
                                    <td>{{ purchaseReturn ? purchaseReturn.date : '' }}</td>
                                </tr>
                            </table>
                        </v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col cols="12">
                            <table class="invoice-details" border="1px solid #ccc;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th colspan="2">Description</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(purchase, sl) in purchaseReturn ? purchaseReturn.return_details : []" :key="sl">
                                        <td class="text-center">{{ sl + 1 }}</td>
                                        <td colspan="2" class="text-center">{{ purchase.product.code }} {{ purchase.product.name }}</td>
                                        <td class="text-center">{{ purchase.quantity }}</td>
                                        <td class="text-center">{{ purchase.return_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Total Amount</td>
                                        <td class="text-center"><strong>{{ purchaseReturn ? purchaseReturn.total : 0.00 }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <p>{{ purchaseReturn ? purchaseReturn.note : '' }}</p>
                        </v-col>
                    </v-row>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'PurchaseReturnInvoice',

    data: () => ({
        purchaseReturn: {
            supplier: {}
        }
    }),

    async created() {
        await this.$store.dispatch('purchase/getPurchaseReturns', {id: this.$route.params.id})
        this.purchaseReturn = await this.$store.getters['purchase/purchaseReturns'][0]
        this.setStyle();
        await this.$store.dispatch('companyProfile/getCompanyProfile')
    },

    methods: {
        async print(){
            let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
            let printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}, left=0, top=0`);
            let image = await this.$store.getters['companyProfile/company'].image;
            let ImagePath = `${this.$store.state.hostName}/${image}`;
            let companyName = this.$store.getters['companyProfile/company'].company_name;
            let address = this.$store.getters['companyProfile/company'].address;
            let contactUs = this.$store.getters['companyProfile/company'].contact_us;
            let email = this.$store.getters['companyProfile/company'].email;
            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Investigation Payment Slip</title>
                    <style>
                    </style>
                </head>
                <body>
                    <div>
                        <div class="container">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <td>
                                            <div class="custom-row">
                                                <div class="col-xs-2">
                                                    <img src="`+ImagePath+`" alt="Logo" style="height:90px; width:90%;object-fit: contain;" />
                                                </div>
                                                <div class="col-xs-10">
                                                    <strong style="font-size:18px;">${companyName}</strong><br>
                                                    <p style="white-space:pre-line;margin:0px">Address : ${address}</p>
                                                    <p style="margin:0px">Mobile : ${contactUs}</p>
                                                    <p style="margin:0px">E-mail : ${email}</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="custom-row">
                                                <div class="col-xs-12">
                                                    ${invoiceContent}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <div style="width:100%;height:50px;">&nbsp;</div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            
                            <div style="position:fixed;left:0;bottom:0px;width:100%;">
                                <div class="custom-row">
                                    <div class="col-xs-6">
                                        <p class="mt-60">
                                            <span style="text-decoration:overline;font-weight:500;font-size:14px">Received By</span>
                                        </p>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="mt-60">
                                            <p class="text-right">
                                                <span style="text-decoration:overline;font-weight:500;font-size:14px">Authorized Signature</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                    
                </body>
                </html>
            `);
            
            let invoiceStyle = printWindow.document.createElement('style');
            invoiceStyle.innerHTML = this.style.innerHTML;
            printWindow.document.head.appendChild(invoiceStyle);
            printWindow.moveTo(0, 0);
            
            printWindow.focus();
            await new Promise(resolve => setTimeout(resolve, 1000));
            printWindow.print();
            printWindow.close();
        },

        setStyle(){
            this.style = document.createElement('style');
            this.style.innerHTML = `
                .custom-row {
                    width: 100%;
                    display: block;
                }
                .print-btn a{
                    background: #CFD8DC;
                    display: inline-block;
                    padding: 3px 13px;
                    border-radius: 5px;
                    color: #000 !important;
                }
                .print-btn a:hover {
                    background: #B0BEC5;
                }
                .invoice-title {
                    text-align: center;
                    font-weight: bold;
                    font-size: 15px;
                    margin-bottom: 15px;
                    padding: 5px;
                    border-top: 1px dotted #454545;
                    border-bottom: 1px dotted #454545;
                }
                .col-xs-12 {
                    width: 100%;
                }
                .col-xs-10 {
                    width: 80%;
                    float: left;
                }
                .col-xs-9 {
                    width: 70%;
                    float: left;
                }
                .col-xs-7 {
                    width: 60%;
                    float: left;
                }
                .col-xs-6 {
                    width: 50%;
                    float: left;
                }
                .col-xs-5 {
                    width: 40%;
                    float: left;
                }
                .col-xs-4 {
                    width: 35%;
                    float: left;
                }
                .col-xs-3 {
                    width: 30%;
                    float: left;
                }
                .col-xs-2 {
                    width: 20%;
                    float: left;
                }
                .b-text {
                    font-weight: 500;
                    font-size: 15px;
                }
                .normal-text {
                    font-size: 14px;
                    margin: 0px;
                }
                .invoice-details {
                    width: 100%;
                    border-collapse: collapse;
                    border:1px solid #ccc;
                }
                .invoice-details thead {
                    font-weight: 500;
                    text-align:center;
                }
                .invoice-details tbody td{
                    padding: 0px 5px;
                }
                .text-center {
                    text-align: center;
                }
                .text-right {
                    text-align: right;
                }
                .line {
                    border-bottom: 1px solid #ccc;
                    margin-top: 15px;
                    margin-bottom: 15px;
                }
                .mt-60 {
                    margin-top: 60px;
                }
                .mr-20 {
                    margin-right: 20px;
                }
                .ml-20 {
                    margin-left: 20px;
                }
                .ft-fiext {
                    position: fixed;
                    bottom: 0;
                }
                .cls {
                    clear: both;
                }
            `;
            document.head.appendChild(this.style);
        },
    }
}
</script>

<style lang="scss" scoped>
    .invoice-title {
        text-align: center;
        font-weight: bold;
        font-size: 15px;
        margin-bottom: 15px;
        padding: 5px;
        border-top: 1px dotted #454545;
        border-bottom: 1px dotted #454545;
    }
    .table tr td:first-child {
        font-weight: bold;
    }
</style>