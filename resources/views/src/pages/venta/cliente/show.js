
import React, { Component } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Col, Row } from 'antd';

import TextField from '@mui/material/TextField';
import Swal from 'sweetalert2';

function ClienteShow() {
    const navigate = useNavigate();
    const params = useParams();
    return (
        <>
            <ClienteShowPrivate 
                navigate={navigate}
                params={params}
            />
        </>
    );
};

class ClienteShowPrivate extends Component {

    constructor( props) {
        super( props );
        this.state = {
            visible_store: false,
            loading: false,
            disabled: false,

            nombre: "",
            apellido: "",
            nit: "",
            telefono: "",
            email: "",
        };
    };
    componentDidMount() {
        this.get_data();
    };
    get_data( ) {
        axios.get( "/api/cliente/show/" + this.props.params.idcliente ) . then ( ( resp ) => {
            console.log(resp)
            if ( resp.data.rpta === 1 ) {
                this.setState( {
                    nombre: resp.data.cliente.nombre ? resp.data.cliente.nombre : "",
                    apellido: resp.data.cliente.apellido ? resp.data.cliente.apellido : "",
                    nit: resp.data.cliente.nit ? resp.data.cliente.nit : "",
                    telefono: resp.data.cliente.telefono ? resp.data.cliente.telefono : "",
                    email: resp.data.cliente.email ? resp.data.cliente.email : "",
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
                <Card title={"DETALLE CLIENTE"} bordered 
                    extra={ 
                        <Button type="primary" danger
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/cliente/index" );
                            } }
                        >
                            Atras
                        </Button> 
                    }
                    style={{ minWidth: '100%', width: '100%', maxWidth: '100%', }}
                >
                    <Row gutter={[16, 24]}>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth
                                label="Nombre" size="small"
                                value={this.state.nombre}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 16, } } >
                            <TextField
                                fullWidth
                                label="Apellido" size="small"
                                value={this.state.apellido}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                    </Row>
                    <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                        <Col xs={{ span: 24, }} sm={ { span: 6, } } >
                            <TextField
                                fullWidth
                                label="Nit" size="small"
                                value={this.state.nit}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 6, } } >
                            <TextField
                                fullWidth
                                label="Tèlefono" size="small"
                                value={this.state.telefono}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 12, } } >
                            <TextField
                                fullWidth
                                label="Email" size="small"
                                value={this.state.email}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                    </Row>
                </Card>
            </>
        );
    }
};

export default ClienteShow;
