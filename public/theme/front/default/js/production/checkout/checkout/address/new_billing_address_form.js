var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

import { ADD_ALERT, ADD_APP_STATE } from "../../../../../../../../js/production/event-types.js";
import AddressForm from "../../../../production/customer/account/address.js";

export default function BillingAddressForm(props) {
    const dispatch = ReactRedux.useDispatch();
    const onComplete = response => {
        if (_.get(response, 'payload.data.addBillingAddress.status') === true) {
            let address = _.get(response, 'payload.data.addBillingAddress.address');
            let setAddresses = _.get(props, 'setAddresses');
            setAddresses(() => {
                let flag = false;
                let newAddress = _.get(props, 'addresses').map((a, i) => {
                    if (a.customer_address_id === address.customer_address_id) {
                        flag = true;
                        a = _extends({}, address, { used: true });
                    }
                    return a;
                });
                if (flag === false) newAddress = newAddress.concat(_extends({}, address, { used: true }));

                return newAddress;
            });
            _.get(props, 'setShowForm')(false);
            dispatch({
                'type': ADD_APP_STATE,
                'payload': {
                    'appState': {
                        'cart': {
                            'shippingAddress': address
                        }
                    }
                }
            });
        } else {
            dispatch({ 'type': ADD_ALERT, 'payload': { alerts: [{ id: "checkout_billing_address_error", message: _.get(response, 'payload.data.addBillingAddress.message'), type: "error" }] } });
        }
    };

    const onError = () => {
        dispatch({ 'type': ADD_ALERT, 'payload': { alerts: [{ id: "checkout_billing_address_error", message: 'Something wrong. Please try again', type: "error" }] } });
    };

    return React.createElement(
        "div",
        { className: "uk-width-1-1" },
        React.createElement(
            "div",
            null,
            React.createElement(
                "strong",
                null,
                "New address"
            )
        ),
        React.createElement(AddressForm, {
            action: _.get(props, 'action'),
            countries: _.get(props, 'countries'),
            onComplete: onComplete,
            onError: onError
        })
    );
}