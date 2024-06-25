<template>
    <div class="container">
        <div class="custom-row">
            <div class="col-xs-12">
                <span class="print-btn"><a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a></span>
            </div>
        </div>
        
        <div id="invoiceContent">
            <div class="custom-row">
                <div class="invoice-title">
                   Damage Invoice
                </div>
            </div>
            <div class="custom-row">
                <div class="col-xs-7">
                    <strong class="b-text">Save by:</strong> <span class="normal-text">{{ damage.added_by ? damage.added_by.name : '' }}</span>
                </div>
                <div class="col-xs-5 text-right">
                    
                    <strong class="b-text">Invoice No:</strong> <span class="normal-text">{{ damage.invoice }}</span><br>
                    <strong class="b-text">Entry Date:</strong> <span class="normal-text">{{ damage.created_at | formatDateTime('DD-MM-YYYY h:mm a') }}</span><br>
                </div>
                <div class="cls"></div>
            </div>
            <div class="custom-row">
                <div class="line">&nbsp;</div>
            </div>
            <div class="custom-row">
                <div class="col-xs-12">
                    <table class="invoice-details" border="1px solid #ccc;">
                        <thead>
                            <tr>
                                <td>Sl.</td>
                                <td colspan="2">Description</td>
                                <td>Quantity</td>
                                <td>Damage Rate</td>
                                <td>Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(detail, ind) in damage.damage_details" :key="ind">
                                <td class="text-center">{{ ind + 1 }}</td>
                                <td colspan="2">{{ detail.product != null ? detail.product.name :'' }}</td>
                                <td class="text-right">{{ detail.quantity }}</td>
                                <td class="text-right" width="20%">{{ detail.purchase_rate }}</td>
                                <td class="text-right" width="20%">{{ detail.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
  
            <div class="custom-row">
                <div class="col-xs-12">
                    <p style="margin-top: 25px"><strong>Note : </strong> {{ damage.note }}</p>
                </div>
            </div>
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
</template>

<script>
import moment from 'moment';
export default {
    name: 'DamageInvoice',
    
    data(){
        return {
            damage:{},
            style: null,
        }
    },

    filters: {
        formatDateTime(dt, format) {
            return dt == '' || dt == null ? '' : moment(dt).format(format);
        }
    },

    created(){
        this.setStyle();
        this.getDamages();
        this.getCompanyProfile();
    },

    methods:{
        getCompanyProfile() {
            this.$store.dispatch('companyProfile/getCompanyProfile')
        },

        async getDamages(){
            await this.$store.dispatch('damage/getDamages', {id: this.$route.params.id});
            this.damage = await this.$store.getters['damage/damages'][0];
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
                .paid-text {
                    padding:30px 0px;
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
        async print(){
            let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
            let printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}, left=0, top=0`);
            let ImagePath = '';
            let companyName = '';
            let address = '';
            let contactUs = '';
            let email = '';
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
        }
    }
}
</script>

<style scoped>
    .container {
        width: 80%;
        margin: 0px auto;
    }
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
    .paid-text {
        padding:30px 0px;
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
</style>