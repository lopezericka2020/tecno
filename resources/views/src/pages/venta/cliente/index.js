
import React, { Component } from 'react';
import { useNavigate } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Col, Modal, Row, Table, Tooltip } from 'antd';
import { DeleteOutlined, EditOutlined, EyeOutlined } from '@ant-design/icons';

import Swal from 'sweetalert2';

function ClienteIndex() {
    const navigate = useNavigate();
    return (
        <>
            <ClienteIndexPrivate 
                navigate={navigate}
            />
        </>
    );
};

class ClienteIndexPrivate extends Component {

    constructor( props) {
        super( props );
        this.state = {
            visible_delete: false,
            loading: false,

            array_cliente: [],
            search: "",
            paginate: 10,
            page: 1,
            idcliente: null,
        };
        this.columns = [ 
            {
                title: 'Nro',
                dataIndex: 'nro',
                key: 'nro',
            },
            {
                title: 'Nombre',
                dataIndex: 'nombre',
                key: 'nombre',
            },
            {
                title: 'Apellido',
                dataIndex: 'apellido',
                key: 'apellido',
            },
            {
                title: 'Nit',
                dataIndex: 'nit',
                key: 'nit',
            },
            {
                title: 'Tèlefono',
                dataIndex: 'telefono',
                key: 'telefono',
            },
            {
                title: 'Acción',
                dataIndex: 'accion',
                render: (text, record) => {
                    return (
                        <>
                            <Tooltip title="editar">
                                <Button shape="circle" style={ { marginRight: 5, } }
                                    icon={<EditOutlined style={ { position: 'relative', top: -2, } } />} 
                                    onClick={ ( evt ) => {
                                        evt.preventDefault();
                                        this.props.navigate( "/cliente/edit/" + record.cliente.idcliente );
                                    } }
                                />
                            </Tooltip>
                            <Tooltip title="ver">
                                <Button shape="circle" style={ { marginRight: 5, } }
                                    icon={<EyeOutlined style={ { position: 'relative', top: -2, } } />} 
                                    onClick={ ( evt ) => {
                                        evt.preventDefault();
                                        this.props.navigate( "/cliente/show/" + record.cliente.idcliente );
                                    } }
                                />
                            </Tooltip>
                            <Tooltip color={"red"} title="eliminar">
                                <Button shape="circle" style={ { marginRight: 5, } }
                                    icon={<DeleteOutlined style={ { position: 'relative', top: -2, } } />} 
                                    onClick={ ( evt ) => {
                                        evt.preventDefault();
                                        Modal.confirm({
                                            title: 'Eliminar Cliente',
                                            content: 'Estas seguro de eliminar cliente?',
                                            okText: 'Eliminar',
                                            cancelText: 'Cancelar',
                                            onOk: () => {
                                                axios.post( "/api/cliente/delete/" + record.cliente.idcliente ) . then ( ( resp ) => {
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
        axios.get( "/api/cliente/index?page=" + page + "&search=" + search + "&paginate=" + paginate ) . then ( ( resp ) => {
            console.log(resp)
            if ( resp.data.rpta === 1 ) {
                let array = [];
                for (let index = 0; index < resp.data.arrayCliente.length; index++) {
                    const element = resp.data.arrayCliente[index];
                    let detalle = {
                        nro: index + 1,
                        nombre: element.nombre,
                        apellido: element.apellido,
                        nit: element.nit,
                        telefono: element.telefono,
                        cliente: element,
                    };
                    array.push(detalle);
                }
                this.setState( {
                    array_cliente: array,
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
                <Card title={"CLIENTE"} bordered 
                    extra={ 
                        <Button type="primary" danger
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/cliente/create" );
                            } }
                        >
                            Nuevo
                        </Button> 
                    }
                    style={{ minWidth: '100%', width: '100%', maxWidth: '100%', }}
                >
                    <Row gutter={[16, 24]}>
                        <Col xs={{ span: 24, }}>
                            <Table columns={this.columns} dataSource={this.state.array_cliente} 
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

export default ClienteIndex;
