
import React, { Component } from 'react';
import { useNavigate } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Col, Row, Table, Tooltip } from 'antd';
import { EditOutlined, EyeOutlined } from '@ant-design/icons';

import Swal from 'sweetalert2';

function ProveedorIndex() {
    const navigate = useNavigate();
    return (
        <>
            <ProveedorIndexPrivate 
                navigate={navigate}
            />
        </>
    );
};

class ProveedorIndexPrivate extends Component {

    constructor( props) {
        super( props );
        this.state = {
            visible_delete: false,
            loading: false,

            array_proveedor: [],
            search: "",
            paginate: 10,
            page: 1,
            idproveedor: null,
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
                title: 'Razon Social',
                dataIndex: 'razonsocial',
                key: 'razonsocial',
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
                                        this.props.navigate( "/proveedor/edit/" + record.proveedor.idproveedor );
                                    } }
                                />
                            </Tooltip>
                            <Tooltip title="ver">
                                <Button shape="circle" style={ { marginRight: 5, } }
                                    icon={<EyeOutlined style={ { position: 'relative', top: -2, } } />} 
                                    onClick={ ( evt ) => {
                                        evt.preventDefault();
                                        this.props.navigate( "/proveedor/show/" + record.proveedor.idproveedor );
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
        axios.get( "/api/proveedor/index?page=" + page + "&search=" + search + "&paginate=" + paginate ) . then ( ( resp ) => {
            console.log(resp)
            if ( resp.data.rpta === 1 ) {
                let array = [];
                for (let index = 0; index < resp.data.arrayProveedor.length; index++) {
                    const element = resp.data.arrayProveedor[index];
                    let detalle = {
                        nro: index + 1,
                        nombre: element.nombre,
                        apellido: element.apellido,
                        nit: element.nit,
                        telefono: element.telefono,
                        razonsocial: element.razonsocial,
                        proveedor: element,
                    };
                    array.push(detalle);
                }
                this.setState( {
                    array_proveedor: array,
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
                <Card title={"PROVEEDOR"} bordered 
                    extra={ 
                        <Button type="primary" danger
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/proveedor/create" );
                            } }
                        >
                            Nuevo
                        </Button> 
                    }
                    style={{ minWidth: '100%', width: '100%', maxWidth: '100%', }}
                >
                    <Row gutter={[16, 24]}>
                        <Col xs={{ span: 24, }}>
                            <Table columns={this.columns} dataSource={this.state.array_proveedor} 
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

export default ProveedorIndex;
