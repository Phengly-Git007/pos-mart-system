import React, { Component } from 'react'
import ReactDOM from 'react-dom';
import axios from 'axios';
import Swal from 'sweetalert2';
import {sum} from 'lodash';

 class Cart extends Component {

    constructor(props){
        super(props)
        this.state = {
            cart : [],
            barcode : '',
            products : [],
            customers : [],
            search : '',
            customer_id : '',
        }

        this.loadCart              = this.loadCart.bind(this);
        this.handleOnChangeBarcode = this.handleOnChangeBarcode.bind(this);
        this.handleScanBarcode     = this.handleScanBarcode.bind(this);
        this.handleChangeQty       = this.handleChangeQty.bind(this);
        this.handleClearCart       = this.handleClearCart.bind(this);
        this.loadProducts          = this.loadProducts.bind(this);
        this.handleChangeSearch    = this.handleChangeSearch.bind(this);
        this.handleSearch          = this.handleSearch.bind(this);
        this.loadCustomers         = this.loadCustomers.bind(this);
        this.setCustomerID         = this.setCustomerID.bind(this);
        this.handleCartSubmit      = this.handleCartSubmit.bind(this);
    }

    componentDidMount(){
        this.loadCart();
        this.loadProducts();
        this.loadCustomers();
    }
    // load barcode
    handleOnChangeBarcode(event){
        const barcode = event.target.value;
        console.log(barcode);
        this.setState({barcode})
    }

    loadCustomers(){

        axios.get('/admin/customers').then(res => {
            const customers = res.data;
            this.setState({customers})
        })
    }

    setCustomerID(event){
        this.setState({customer_id:event.target.value});
    }

    loadProducts(search = ''){

        const query = !!search ? `?search=${search}` : '';
        axios.get(`/admin/products${query}`).then(res => {
            const products = res.data.data;
            this.setState({products})
        })
    }

    // show cart
    loadCart () {
      axios.get('/admin/cart').then(res =>{
        const cart = res.data;
       this.setState({cart})
      });
    }
// scan barcode
    handleScanBarcode(event){
        event.preventDefault();
        const {barcode} = this.state;
        if(!!barcode){
            axios.post('/admin/cart',{barcode}).then(res =>{
                this.loadCart();
                this.setState({barcode : '' })
            }).catch(err =>{
               Swal.fire(
                'Error !',
                err.response.data.message,
                'error'
               )
            })
        }
    }
// change product quantity in cart
    handleChangeQty(product_id,qty){
        const cart = this.state.cart.map(c => {
            if(c.id === product_id){
                c.pivot.quantity = qty;
            }
            return c;
        });
        this.setState({cart})
        axios.post('/admin/cart/change-qty',{product_id,quantity:qty}).then(res => {

        }).catch(err =>{
            Swal.fire(
                'Error !',
                err.response.data.message,
                'error'
               )
        })
    }
// delete product from cart
    handleClickDelete(product_id){
        axios.post('/admin/cart/delete', {product_id, _method: 'DELETE'}).then(res => {
            const cart = this.state.cart.filter(c => c.id !== product_id);
            this.setState({cart})
        })
    }
// delete all product from cart
    handleClearCart(){
        axios.post('/admin/cart/clear', { _method: 'DELETE'}).then(res => {
            this.setState({cart : []})
        })
    }

    handleCartSubmit(){
        // sweetalert
        Swal.fire({
            title: 'balance payment',
            input: 'text',
            inputAttributes: {
              autocapitalize: 'off'
            },
            inputValue : this.getTotals(this.state.cart),
            showCancelButton: true,
            confirmButtonText: 'Send',
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                axios.post('/admin/orders',{customer_id : this.state.customer_id ,amount}).then(res => {
                    this.loadCart();
                 }).catch(err =>{
                    Swal.showValidationMessage(err.response.data.message)
                 })
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: ' paymant has been checked ',
                    showConfirmButton: false,
                    timer: 3000
                  })
            }
          })
        // end sweetalert

    }

// sum total price in cart
    getTotals(cart){
       const total = cart.map(c => c.pivot.quantity * c.price);
      return sum(total);
    }

    handleChangeSearch(event){
        const search = event.target.value;
        this.setState({search})
    }

    handleSearch(event){
        if(event.keyCode === 13){
            this.loadProducts(event.target.value);
        }
    }

    addProductTocart(barcode){
        let product = this.state.products.find(p => p.barcode === barcode);
        if(!!product){
            // if product already on cart
            let cart = this.state.cart.find(c => c.id === product.id);
            if(!!cart){
                this.setState({cart: this.state.cart.map(c=>{
                    if(c.id === product.id && product.quantity > c.pivot.quantity){
                        c.pivot.quantity = c.pivot.quantity + 1;
                    }
                    return c;
                })
              });
            }
            else{
                if(product.quantity > 0){
                    product={
                        ...product,pivot:{
                            quantity : 1,
                            product_id : product.id,
                            user_id : 1
                        }
                    };
                    this.setState({cart:[...this.state.cart,product]})
                }
            }
        }
        axios.post('/admin/cart',{barcode}).then(res =>{
            this.loadCart();
            this.setState({barcode : '' })
        }).catch(err =>{
           Swal.fire(
            'Error !',
            err.response.data.message,
            'error'
           )
        })
    }

  render() {
    const {cart,barcode,products,customers} = this.state;
    console.log(this.state.customer_id);
    return (
        <div className="row">
            <div className="col-md-6 col-lg-4">
                <div className="row mb-2">
                    <div className="col">
                        <form onSubmit={this.handleScanBarcode} >
                            <input type="text" className="form-control"
                                placeholder="Scan barcode..."
                                value={barcode} onChange={this.handleOnChangeBarcode}
                            />
                        </form>
                    </div>
                <div className="col">
                    <select className="form-control" onChange={this.setCustomerID} >
                        <option value="">Select customer</option>
                        {customers.map(cus => <option key={cus.id} value={cus.id}>{`${cus.first_name} ${cus.last_name}`}</option>)}
                    </select>
                </div>
                </div>
                <div className="user-cart">
                <div className="card">
                    <table className="table table-striped">
                    <thead>
                        <tr><th>Product Name</th>
                        <th>Quantity</th>
                        <th className="text-right">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        {cart.map(c=> (
                            <tr key={c.id}>
                            <td>{c.name}</td>
                            <td><input type="text"  className="form-control form-control-sm qty "
                                 value={c.pivot.quantity}
                                 onChange={event => this.handleChangeQty(c.id,event.target.value)}

                                />
                                <button className="btn btn-danger btn-sm" onClick={ () => this.handleClickDelete(c.id)}><i className="fas fa-trash" /></button>
                            </td>
                            <td className="text-right">{window.APP.currency_symbol} {(c.price * c.pivot.quantity).toFixed(2)}</td>
                            </tr>
                        ))}
                    </tbody>
                    </table>
                </div>
                </div>
                <div className="row mb-2">
                <div className="col">Total :</div>
                <div className="col text-right">{window.APP.currency_symbol} {this.getTotals(cart).toFixed(2)}</div>
                </div>
                <div className="row">
                <div className="col">
                    <button type="button" className="btn btn-danger btn-sm btn-block"
                     onClick={this.handleClearCart} disabled={!cart.length}>
                        <i className="fas fa-trash" />
                         Cancel
                    </button>
                </div>
                <div className="col ">
                    <button type="button" className="btn btn-primary btn-sm btn-block"
                         disabled={!cart.length} onClick={this.handleCartSubmit}>
                        <i className="fas fa-solid fa-share" />
                        Submit
                    </button>
                </div>
                </div>
            </div>
            <div className="col-md-6 col-lg-8">
                <div className="mb-2">
                    <input type="text" className="form-control" placeholder="Search Product..."
                        onChange={this.handleChangeSearch}
                        onKeyDown={this.handleSearch}
                    />
                </div>
                <div className="order-product">
                  {products.map(p => (
                     <div key={p.id} className="item" onClick={() => this.addProductTocart(p.barcode)} ><img src={p.image_url} alt="true" />
                         <h6>{p.name} <br/> ({p.quantity}) </h6>
                     </div>
                  ))}
                </div>
            </div>
        </div>
    )
  }
}
export default Cart;

if(document.getElementById('cart')){
    ReactDOM.render(<Cart />, document.getElementById('cart'));
}
