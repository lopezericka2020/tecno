
import React, { Component } from 'react';
import { useNavigate } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Col, Modal, Row, Table, Tooltip } from 'antd';
import { DeleteOutlined, EditOutlined, EyeOutlined } from '@ant-design/icons';

import Swal from 'sweetalert2';

function VentaIndex() {
    const navigate = useNavigate();
    return (
        <>
            <VentaIndexPrivate 
                navigate={navigate}
            />
        </>
    );
};

class VentaIndexPrivate extends Component {

    constructor( props) {
        super( props );
        this.state = {
            visible_delete: false,
            loading: false,

            array_venta: [],
            search: "",
            paginate: 10,
            page: 1,
            idventa: null,
        };
        this.columns = [ 
            {
                title: 'Nro',
                dataIndex: 'nro',
                key: 'nro',
            },
            {
                title: 'Cliente',
                dataIndex: 'cliente',
                key: 'cliente',
            },
            {
                title: 'Mto. Total',
                dataIndex: 'montototal',
                key: 'montototal',
            },
            {
                title: 'Nota',
                dataIndex: 'nota',
                key: 'nota',
            },
            {
                title: 'Acción',
                dataIndex: 'accion',
                render: (text, record) => {
                    return (
                        <>
                            <Tooltip title="ver">
                                <Button shape="circle" style={ { marginRight: 5, } }
                                    icon={<EyeOutlined style={ { position: 'relative', top: -2, } } />} 
                                    onClick={ ( evt ) => {
                                        evt.preventDefault();
                                        this.props.navigate( "/venta/show/" + record.venta.idventa );
                                    } }
                                />
                            </Tooltip>
                            <Tooltip color={"red"} title="eliminar">
                                <Button shape="circle" style={ { marginRight: 5, } }
                                    icon={<DeleteOutlined style={ { position: 'relative', top: -2, } } />} 
                                    onClick={ ( evt ) => {
                                        evt.preventDefault();
                                        Modal.confirm({
                                            title: 'Eliminar Venta',
                                            content: 'Estas seguro de eliminar venta?',
                                            okText: 'Eliminar',
                                            cancelText: 'Cancelar',
                                            onOk: () => {
                                                axios.post( "/api/venta/delete/" + record.venta.idventa ) . then ( ( resp ) => {
                                                    console.log(resp)
                                                    if ( resp.data.rpta === 1 ) {
                                                        Swal.fire( {
                                                            position: 'top-end',
                                                            icon: 'success',
                                                            title: resp.data.message,
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                        } );
                                                        this.get_data();
                                                    }
                                                    if ( resp.data.rpta === -1 ) {
                                                        Swal.fire( {
                                                            position: 'top-end',
                                                            icon: 'error',
                                                            title: resp.data.message,
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                        } );
                                                    }
                                                    if ( resp.data.rpta === 0 ) {
                                                        Swal.fire( {
                                                            position: 'top-end',
                                                            icon: 'warning',
                                                            title: resp.data.message,
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                        } );
                                                    }
                                                    if ( resp.data.rpta === -5 ) {
                                                        Swal.fire( {
                                                            position: 'top-end',
                                                            icon: 'warning',
                                                            title: resp.data.message,
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                        } );
                                                    }
                                        
                                                } ) . catch ( ( error ) => {
                                                    console.log(error);
                                                    Swal.fire( {
                                                        position: 'top-end',
                                                        icon: 'error',
                                                        title: 'Hubo problemas con el servidor',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    } );
                                                } );
                                            }
                                          });
                                    } }
                                />
                            </Tooltip>
                        </>
                    )
                },
            }
        ];
    };
    componentDidMount() {
        this.get_data();
    };
    get_data( search = "", paginate = 10, page = 1 ) {
        axios.get( "/api/venta/index?page=" + page + "&search=" + search + "&paginate=" + paginate ) . then ( ( resp ) => {
            console.log(resp)
            if ( resp.data.rpta === 1 ) {
                let array = [];
                for (let index = 0; index < resp.data.arrayVenta.length; index++) {
                    const element = resp.data.arrayVenta[index];
                    let detalle = {
                        nro: index + 1,
                        cliente: element.nombre + " " + element.apellido,
                        venta: element,
                        montototal: element.montototal,
                        nota: element.nota,
                    };
                    array.push(detalle);
                }
                this.setState( {
                    array_venta: array,
                } );
            }
            if ( resp.data.rpta === -5 ) {
                Swal.fire( {
                    position: 'top-end',
                    icon: 'warning',
                    title: resp.data.message,
                    showConfirmButton: false,
                    timer: 1500
                } );
            }

        } ) . catch ( ( error ) => {
            console.log(error);
            Swal.fire( {
                position: 'top-end',
                icon: 'error',
                title: 'Hubo problemas con el servidor',
                showConfirmButton: false,
                timer: 1500
            } );
        } );
    };

    render() {
        return (
            <>
                <Card title={"VENTA"} bordered 
                    extra={ 
                        <Button type="primary" danger
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/venta/create" );
                            } }
                        >
                            Nuevo
                        </Button> 
                    }
                    style={{ minWidth: '100%', width: '100%', maxWidth: '100%', }}
                >
                    <Row gutter={[16, 24]}>
                        <Col xs={{ span: 24, }}>
                            <Table columns={this.columns} dataSource={this.state.array_venta} 
                                bordered style={ { width: '100%', minWidth: '100%', } } pagination={false}
                                size='small' rowKey={"nro"} scroll={{ x: '100%', }}
                            />
                        </Col>
                    </Row>
                </Card>
            </>
        );
    }
};

export default VentaIndex;
