/**
 * Gutenberg block controls for codeable user table block
 *
 * This File contains reactDom Javascript code
 * The file is enqueued from inc/frontend/class-frontend.php.
 */

const {registerBlockType} = wp.blocks; // Blocks API
const {createElement}     = wp.element; // React.createElement
const {__}                = wp.i18n; // translation functions
const {InspectorControls} = wp.editor; // Block inspector wrapper
const {TextControl,SelectControl,CheckboxControl,ServerSideRender} = wp.components; // WordPress form inputs and server-side renderer
const {withState} = wp.compose

// Registering Block Type of codeable users table, setting default attribute values.
registerBlockType(
    'codeable-listuser-gutenberg-block/user-table', {
        title: __('Codeable Users Table'), // Block title.
        category: __('common'), //category
        attributes: {
            orderby: {
                default: "user_login"
            },
            showfilter: {
                default: "show"
            },
            order: {
                default: "ASC"
            },
            role: {
                default: "all"
            },
            per_page: {
                default: 10
            }
        },
        // Edit action of guternberg block.
        edit(props) {
            const attributes = props.attributes;
            const setAttributes = props.setAttributes;

            // Function to update per page attribute.
            function changeRecordPerPage(per_page) {
                setAttributes({
                    per_page
                });
            }

            // Function to update Role attribute.
            function changeRealrole(role) {
                setAttributes({
                    role
                });
                if (role != "all") {
                    setAttributes({
                        showfilter: "hide"
                    })
                } else {
                    setAttributes({
                        showfilter: "show"
                    })
                }

            }

            // Function to update Order By attribute.
            function changeOrderBy(orderby) {
                setAttributes({
                    orderby
                });
            }

            // Function to update Order attribute.
            function changeOrderType(order) {
                setAttributes({
                    order
                });
            }

            // Function to update Show Filter attribute.
            function changeShowfilter(showfilter) {
                setAttributes({
                    showfilter
                });
            }

            // Function to Create option object for Role attribute.
            function role_select_options() {
                let roles_array = [];
                let counter = 1;
                let tempObject = {};
                tempObject["value"] = "all";
                tempObject["label"] = __('All Roles');
                roles_array[0] = tempObject;

                $.each(
                    roles_available,
                    function(key, val) {
                        tempObject = {};
                        tempObject["value"] = key;
                        tempObject["label"] = __(val);
                        roles_array[counter] = tempObject;
                        counter++;
                    }
                );

                return roles_array;
            }


            // Display block preview and UI.
            return createElement(
                'div', {},
                [
                    // Preview a block with a PHP render callback.
                    createElement(
                        ServerSideRender, {
                            block: 'codeable-listuser-gutenberg-block/user-table',
                            attributes: attributes
                        }
                    ),
                    // Block inspector
                    createElement(
                        InspectorControls, {
                            id: "codeable-listuser-inspector"
                        },
                        [
                            // A simple select control for Role Filter.
                            createElement(
                                SelectControl, {
                                    value: attributes.showfilter,
                                    label: __('Show Role Filter'),
                                    id: "filterselection",
                                    onChange: changeShowfilter,
                                    options: [{
                                        value: 'show',
                                        label: __("Show Filter")
                                    },
                                        {
                                            value: 'hide',
                                            label: __("Hide Filter")
                                        },
                                    ]
                                }
                            ),
                            // A simple select control for Roles selection.
                            createElement(
                                SelectControl, {
                                    value: attributes.role,
                                    label: __('Which specific Role you want to show'),
                                    help: __('If you want to list specific roles only than you should choose hide filter option in "Show Role Filter" option, otherwise you will be able to see all roles after filtering! so we will select this for you, however you can change it as per need'),
                                    onChange: changeRealrole,
                                    options: role_select_options()
                                }
                            ),
                            // A simple text control for Page page option.
                            createElement(
                                TextControl, {
                                    value: attributes.per_page,
                                    label: __('Record Per Page'),
                                    onChange: changeRecordPerPage,
                                    type: 'number',
                                    min: 2,
                                    step: 1
                                }
                            ),
                            // A simple select control for Orderby selection.
                            createElement(
                                SelectControl, {
                                    value: attributes.orderby,
                                    label: __('Order By'),
                                    onChange: changeOrderBy,
                                    options: [{
                                        value: 'user_login',
                                        label: __("User Name")
                                    },
                                        {
                                            value: 'display_name',
                                            label: __("Display Name")
                                        },
                                    ]
                                }
                            ),
                            // A simple select control for Order Type Field.
                            createElement(
                                SelectControl, {
                                    value: attributes.order,
                                    label: __('Default Order Type'),
                                    onChange: changeOrderType,
                                    options: [{
                                        value: 'ASC',
                                        label: __("Ascending")
                                    },
                                        {
                                            value: 'DESC',
                                            label: __("Descending")
                                        },
                                    ]
                                }
                            )
                        ]
                    )
                ]
            )
        },
        save() {
            // save has to exist.
            return null;
        }
    }
);