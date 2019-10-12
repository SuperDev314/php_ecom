import A from "../../../../../../../../js/production/a.js";

function Items() {
    const items = ReactRedux.useSelector(state => _.get(state, 'appState.cart.items', []));
    return React.createElement(
        "div",
        { id: "summary-items" },
        React.createElement(
            "table",
            { className: "uk-table uk-table-small" },
            React.createElement(
                "thead",
                null,
                React.createElement(
                    "tr",
                    null,
                    React.createElement(
                        "td",
                        null,
                        React.createElement(
                            "span",
                            null,
                            "Product"
                        )
                    ),
                    React.createElement(
                        "td",
                        null,
                        React.createElement(
                            "span",
                            null,
                            "Quantity"
                        )
                    ),
                    React.createElement(
                        "td",
                        null,
                        React.createElement(
                            "span",
                            null,
                            "Total"
                        )
                    )
                )
            ),
            React.createElement(
                "tbody",
                null,
                items.map((item, index) => {
                    return React.createElement(
                        "tr",
                        { key: index },
                        React.createElement(
                            "td",
                            null,
                            React.createElement(A, { url: item.product_url, text: item.product_name, classes: "uk-link-muted" })
                        ),
                        React.createElement(
                            "td",
                            null,
                            React.createElement(
                                "span",
                                null,
                                item.qty
                            )
                        ),
                        React.createElement(
                            "td",
                            null,
                            React.createElement(
                                "span",
                                null,
                                item.total
                            )
                        )
                    );
                })
            )
        )
    );
}
export { Items };