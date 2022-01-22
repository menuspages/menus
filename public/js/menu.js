const PICKUP_TYPES = {
    DELIVERY: 1,
    TAKE_AWAY: 2,
    LOCAL: 3
}
let app = new Vue({
    el: '#app',
    data: {
        cart: {},
        cartItemsCount: 0,
        notification: true,
        items: [],
        loading: true,
        modalLoading: false,
        activeCategoryId: 0,
        validDate: false,
        location: 'null',
        name: '',
        phone: '',
        phone_code: phone_code(),
        address: '',
        notes: '',
        payment_type: '',
        transfer_type_recp: '',
        pickup_type: PICKUP_TYPES.DELIVERY,
        quantity: 1,
        sub_detail_note: '',
    },
    methods: {
        isBankTransfer() {
            if (this.payment_type == "Money Transfer" || this.payment_type == "تحويل بنكي") {
                return true;
            }
            return false;
        },
        saveImage(image) {
            this.transfer_type_recp = image

        },
        setPaymentType(payment_type) {
            this.payment_type = payment_type
        },
        getPhoneCode() {
            return "{{$restaurant->phone_code}}";
        },
        updateSubDetails(product_id, sub_details) {
            let item = null;
            if (typeof product_id === 'object') {
                item = product_id;
                id = item.id;
            }

            if (typeof this.cart[product_id] !== 'undefined') {
                return false;
            }
            this.cartItemsCount++;
            if (!item) {
                item = this.items.find(i => i.id == id);
            }
            this.cart[product_id] = item;

            item.sub_details = sub_details;

            if (item.sub_details != undefined) {
                for (i = 0; i < item.sub_details.length; i++) {
                    item.current_price += Number(item.sub_details[i][1]);
                }
            }
        },
        changeActiveCategory(id) {
            if (this.activeCategoryId && document.getElementById("category-" + id)) {
                document.getElementById('categories').querySelectorAll('.active').forEach(a => a.classList.remove('active'))
                document.getElementById("category-" + id).classList.add('active');
            }
        },
        getItemsOfCategoryId(categoryId) {
            this.loading = true;
            axios.get('/items?category_id=' + categoryId).then(response => {
                this.loading = false;
                this.items = response.data.map(item => {
                    if (this.cart[item.id]) {
                        item.added = true;
                        item.quantity = this.cart[item.id].quantity;
                        this.cart[item.id] = item
                    } else {
                        item.quantity = 0;
                    }
                    return item;
                });
            }).catch(e => {
                this.toggleAlert(e.message, 'danger');
            })
        },
        chooseActiveCategory(id) {
            if (id === this.activeCategoryId) {
                //if there's no categories
                this.loading = false;
                return false;
            }
            this.activeCategoryId = id;
            this.changeActiveCategory(id);
            this.getItemsOfCategoryId(this.activeCategoryId);
        },
        toggleAlert(message, type) {
            $('.notification').toggleClass('show');
            $('.notification div.alert').removeClass(['alert-success', 'alert-danger']).addClass('alert-' + type).find('span').html(message);
            setTimeout(function() {
                $('.notification').toggleClass('show');
            }, 2000)
        },
        changeSubDetailsItems(product_id) {
            Object.values(this.cart).forEach(
                item => {
                    if (item.id == product_id) {
                        item.sub_details = getSubDetailsData(product_id)
                    }
                }
            );
            this.cart = {...this.cart };
        },
        addItemToCart(id, quantity) {

            sub_details = getSubDetailsData(id.id)
                // this block is when you already load all the items in the view using blade in order not to duplicate the work
            let item = null;
            if (typeof id === 'object') {
                item = id;
                id = item.id;
            }

            if (typeof this.cart[id] !== 'undefined') {
                return false;
            }
            this.cartItemsCount++;
            if (!item) {
                item = this.items.find(i => i.id == id);
            }
            this.cart[id] = item;
            item.added = true;
            item.quantity = quantity;
            item.type = "item";

            item.sub_details = sub_details;

            if (item.sub_details != undefined) {
                for (i = 0; i < item.sub_details.length; i++) {
                    item.current_price += Number(item.sub_details[i][1]);
                }
            }

        },

        setQuantity(item, product_id, _quantity) {

            this.quantity = _quantity;
            if (!this.IsQuantityAvailable(_quantity, item)) {
                return "";
            }
            if (this.quantity == 0) {
                this.quantity = 1;
            }
            $("#lblQuantity" + product_id).text(this.quantity)

            Object.values(this.cart).forEach(
                item => {
                    if (item.id == product_id) {
                        item.quantity = this.quantity
                    }
                }
            );
            this.cart = {...this.cart };
        },
        getQuantity(product_id) {
            var quantity = 1;
            Object.values(this.cart).forEach(
                item => {
                    if (item.id == product_id) {
                        quantity = item.quantity;
                    }
                }
            );
            return quantity;
        },
        addToCart(id, sub_details) {

            $('#sub_details_item_' + id.id).removeClass('collapse');
            $('#sub_details_item_' + id.id).animate({ height: '90%' }, 'fast');
            if ($('#sub_details_item_' + id.id).children().length > 0) {

                $('#sub_details_item_' + id.id).find('.btn-close-sub-details').on('click', function() {
                    $('#sub_details_item_' + id.id).animate({ height: '0%' });
                });
            } else {
                this.quantity = 1
                this.addItemToCart(id, this.quantity)
            }


        },
        removeFromCart(id) {
            if (typeof this.cart[id] === 'undefined') {
                return;
            }
            let item = this.items.find(i => i.id == id);

            if (item) {
                item.added = false;
            }
            this.cart[id].quantity = 0;

            if (this.cart[id].sub_details != undefined) {
                for (i = 0; i < this.cart[id].sub_details.length; i++) {
                    this.cart[id].current_price -= Number(this.cart[id].sub_details[i][1]);
                }
            }
            delete this.cart[id];
            this.cartItemsCount--;
            this.cart = {...this.cart };
            resetSubDetailsData(id);
        },

        sub_details_price(item) {
            if (item.sub_details == undefined) {
                return 0;
            }
            var total = 0;
            for (i = 0; i < item.sub_details.length; i++) {
                total += Number(item.sub_details[i][1]);
            }
            return total;
        },
        IsQuantityAvailable(quantity, remaining) {
            if (remaining == null) {
                return true;
            }
            if (quantity > remaining) {
                alert("this quantity for item is not available")
                return false;
            }
            return true;
        },
        changeQuantity(item, id, quantity) {

            if (this.IsQuantityAvailable(this.cart[id].quantity + quantity, this.cart[id].quantity_summary['remaining']) == false) {
                return "";
            }
            if (typeof this.cart[id] === 'undefined') {
                if (quantity === 1) {
                    return this.addToCart(id);
                }
                return false;
            }
            if (quantity === -1 && typeof this.cart[id] !== 'undefined' && this.cart[id].quantity === 1) {
                return this.removeFromCart(id);
            }
            if (this.cart[id].quantity === 1 && quantity === -1) {
                return false;
            }
            this.cart[id].quantity = this.cart[id].quantity + quantity;
            this.cart = {...this.cart };
            $("#lblQuantity" + this.cart[id].id).text(this.cart[id].quantity)
        },
        calculateTotal() {
            let total = 1;
            Object.values(this.cart).forEach(
                item => total += item.quantity * item.current_price
            );
            return total;
        },
        validatePlacingOrder() {
            if (!this.name) {
                this.validDate = false;
                return 'من فضلك املأ كل الحقول المطلوبة';
            }
            if (Number(this.pickup_type) === PICKUP_TYPES.DELIVERY && !this.address) {
                this.validDate = false;
                return 'من فضلك ضع العنوان';
            }

            if (!Object.keys(this.cart).length) {
                this.validDate = false;
                return 'ﻻ يوجد شئ في العربة، اضف الي العربة و حاول مجددا';
            }
            this.validDate = true;
            return '';
        },
        resetCart() {
            let ids = Object.keys(this.cart);
            ids.forEach(id => this.removeFromCart(id));
            this.cartItemsCount = 0;
        },
        resetForm() {
            this.name = '';
            this.phone = '';
            this.address = '';
            this.notes = '';
        },
        setLoading() {
            var name = $(".btn-place-order").text();
            $(".btn-place-order").html('<i class="fas fa-spinner fa-spin"></i>');
            $(".btn-place-order").attr('disabled', true);

            return name
        },
        unsetLoading(name) {
            $(".btn-place-order").html(name);
            $(".btn-place-order").attr('disabled', false);
        },


        submit() {
            var name = this.setLoading();
            if (!$('.admin-note').hasClass("collapse")) {
                var admin_note = $('.admin-note').children('input');
                if (!admin_note.is(':checked')) {
                    alert("You must agree to our terms");
                    $('.admin-note').children('label').css({
                        'color': 'red'
                    });
                    this.unsetLoading(name)
                    return '';
                }
            }

            if (this.isBankTransfer()) {
                if (this.transfer_type_recp == '') {

                    $('#recpBankTransfer').css({
                        'border-color': 'red',
                        'color': 'red'
                    });
                    alert("upload bank tranfer recp please")
                    this.unsetLoading(name)
                    return '';
                }
            }

            let message = this.validatePlacingOrder();
            if (!this.validDate) {
                alert(message);
                this.unsetLoading(name)
                return false;
            }
            this.modalLoading = true;
            axios.post('/place-order', this.prepareRequestBody(), ).then(response => {
                this.modalLoading = false;
                if (response.data.success) {
                    this.unsetLoading(name)
                    saveOrder(response.data.order.id);
                    setTimeout(() => {

                        this.resetCart();
                        this.resetForm();
                        $('#place-order-modal').modal('hide');
                    }, 500)
                    alert("تم انشاء الطلب بنجاح");
                    return this.toggleAlert('تم انشاء الطلب بنجاح', 'success');
                }
                this.unsetLoading(name)
                return this.toggleAlert('عذرا حدث خطأ ما', 'danger');
            }).catch(e => {
                this.unsetLoading(name)
                this.modalLoading = false;
                let errors = e.response.data.errors;
                let message = Object.values(errors) ? Object.values(errors)[0][0] : 'عذرا حدث خطأ ما';
                alert(message)
            });
        },
        changePickUpType(event) {
            $('div#phone-field').hide();
            $('div#address-field').hide();
            if (Number(this.pickup_type) === PICKUP_TYPES.DELIVERY) {
                $('div#address-field').show();
            }
            if (Number(this.pickup_type) === PICKUP_TYPES.DELIVERY || Number(this.pickup_type) === PICKUP_TYPES.TAKE_AWAY) {
                $('div#phone-field').show();
            }

        },
        prepareRequestBody() {
            addSubDetailsNotes()
            let body = {
                items: Object.values(this.cart).map(item => ({
                    id: item.id,
                    quantity: item.quantity,
                    type: item.type,
                    price: item.current_price + this.sub_details_price(item),
                    sub_details: item.sub_details

                })),
                _token: document.querySelector('meta[name=csrf-token]').content,
                name: this.name,
                phone: this.phone_code + this.phone,
                address: this.address,
                transfer_type: this.payment_type,
                date: getCartOptinos('date'),
                allergens: getCartOptinos('allergens'),
                note: getCartOptinos('note'),
                transfer_type_recp: this.transfer_type_recp,
                notes: this.notes,
                pickup_type: this.pickup_type,
                location: this.location
            }

            console.log(body)

            if (Number(this.pickup_type) === PICKUP_TYPES.TAKE_AWAY) {
                delete body['address'];
            }
            console.log(body)
            let formData = new FormData()
            formData.append('items', JSON.stringify(body["items"]))
            formData.append('_token', body["_token"])
            formData.append('name', body["name"])
            formData.append('phone', body["phone"])
            formData.append('address', body["address"])
            formData.append('transfer_type', body["transfer_type"])
            formData.append('transfer_type_recp', body["transfer_type_recp"])
            formData.append('notes', body["notes"])
            formData.append('pickup_type', body["pickup_type"])
            formData.append('location', body["location"])
            return formData;
        }
    },
    mounted() {
        if (typeof document.currentScript.getAttribute('defaultCategory') !== 'undefined') {
            this.chooseActiveCategory(document.currentScript.getAttribute('defaultCategory'));
        }
    }
})