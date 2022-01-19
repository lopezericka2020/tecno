
import React, { Component } from 'react';
import { useNavigate } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Col, Modal, Row, Table, Tooltip } from 'antd';
import { DeleteOutlined, EditOutlined, EyeOutlined } from '@ant-design/icons';

import Swal from 'sweetalert2';

function TerrenoIndex() {
    const navigate = useNavigate();
    return (
        <>
            <TerrenoIndexPrivate 
                navigate={navigate}
            />
        </>
    );
};

class TerrenoIndexPrivate extends Component {

    constructor( props) {
        super( props );
        this.state = {
            visible_delete: false,
            loading: false,

            array_terreno: [],
            search: "",
            paginate: 10,
            page: 1,
            idterreno: null,
        };
        this.columns = [ 
            {
                title: 'Nro',
                dataIndex: 'nro',
                key: 'nro',
            },
            {
                title: 'Descripón',
                dataIndex: 'descripcion',
                key: 'descripcion',
            },
            {
                title: 'Precio',
                dataIndex: 'precio',
                key: 'precio',
            },
            {
                title: 'Ciudad',
                dataIndex: 'ciudad',
                key: 'ciudad',
            },
            {
                title: 'Direcciòn',
                dataIndex: 'direccion',
                key: 'direccion',
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
                                        this.props.navigate( "/terreno/edit/" + record.terreno.idterreno );
                                    } }
                                />
                            </Tooltip>
                            <Tooltip title="ver">
                                <Button shape="circle" style={ { marginRight: 5, } }
                                    icon={<EyeOutlined style={ { position: 'relative', top: -2, } } />} 
                                    onClick={ ( evt ) => {
                                        evt.preventDefault();
                                        this.props.navigate( "/terreno/show/" + record.terreno.idterreno );
                                    } }
                                />
                            </Tooltip>
                            <Tooltip color={"red"} title="eliminar">
                                <Button shape="circle" style={ { marginRight: 5, } }
                                    icon={<DeleteOutlined style={ { position: 'relative', top: -2, } } />} 
                                    onClick={ ( evt ) => {
                                        evt.preventDefault();
                                        Modal.confirm({
                                            title: 'Eliminar Terreno',
                                            content: 'Estas seguro de eliminar terreno?',
                                            okText: 'Eliminar',
                                            cancelText: 'Cancelar',
                                            onOk: () => {
                                                axios.post( "/api/terreno/delete/" + record.terreno.idterreno ) . then ( ( resp ) => {
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
        axios.get( "/api/terreno/index?page=" + page + "&search=" + search + "&paginate=" + paginate ) . then ( ( resp ) => {
            console.log(resp)
            if ( resp.data.rpta === 1 ) {
                let array = [];
                for (let index = 0; index < resp.data.arrayTerreno.length; index++) {
                    const element = resp.data.arrayTerreno[index];
                    let detalle = {
                        nro: index + 1,
                        descripcion: element.descripcion,
                        precio: element.precio,
                        ciudad: element.ciudad,
                        direccion: element.direccion,
                        terreno: element,
                    };
                    array.push(detalle);
                }
                this.setState( {
                    array_terreno: array,
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
                <Card title={"TERRENO"} bordered 
                    extra={ 
                        <Button type="primary" danger
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/terreno/create" );
                            } }
                        >
                            Nuevo
                        </Button> 
                    }
                    style={{ minWidth: '100%', width: '100%', maxWidth: '100%', }}
                >
                    <Row gutter={[16, 24]}>
                        <Col xs={{ span: 24, }}>
                            <Table columns={this.columns} dataSource={this.state.array_terreno} 
                                bordered style={ { width: '100%', minWidth: '100%', } } pagination={false}
                                size='small' rowKey={"nro"} scroll={ { x: '100%', } }
                            />
                        </Col>
                    </Row>
                </Card>
            </>
        );
    }
};

export default TerrenoIndex;
