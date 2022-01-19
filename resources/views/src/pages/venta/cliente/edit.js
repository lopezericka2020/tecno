
import React, { Component } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Col, Row } from 'antd';

import TextField from '@mui/material/TextField';
import Swal from 'sweetalert2';

function ClienteEdit() {
    const navigate = useNavigate();
    const params = useParams();
    return (
        <>
            <ClienteEditPrivate 
                navigate={navigate}
                params={params}
            />
        </>
    );
};

class ClienteEditPrivate extends Component {

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

            errornombre: false,
            errorapellido: false,
            errornit: false,
            errortelefono: false,
            erroremail: false,
        };
    };
    componentDidMount() {
        this.get_data();
    };
    get_data( ) {
        axios.get( "/api/cliente/edit/" + this.props.params.idcliente ) . then ( ( resp ) => {
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
            if ( resp.data.rpta === -1 ) {
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
                    icon: 'error',
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
    onChangeNombre( evt ) {
        this.setState( {
            nombre: evt.target.value,
            errornombre: false,
        } );
    };
    onChangeApellido( evt ) {
        this.setState( {
            apellido: evt.target.value,
            errorapellido: false,
        } );
    };
    onChangeNit( evt ) {
        this.setState( {
            nit: evt.target.value,
            errornit: false,
        } );
    };
    onChangeTelefono( evt ) {
        this.setState( {
            telefono: evt.target.value,
            errortelefono: false,
        } );
    };
    onChangeEmail( evt ) {
        this.setState( {
            email: evt.target.value,
            erroremail: false,
        } );
    };
    onValidate() {
        if ( this.state.nombre.toString().trim().length === 0 ) {
            this.setState( { errornombre: true, } );
            return;
        }
        if ( this.state.apellido.toString().trim().length === 0 ) {
            this.setState( { errorapellido: true, } );
            return;
        }
        if ( this.state.nit.toString().trim().length === 0 ) {
            this.setState( { errornit: true, } );
            return;
        }
        if ( this.state.telefono.toString().trim().length === 0 ) {
            this.setState( { errortelefono: true, } );
            return;
        }
        if ( this.state.email.toString().trim().length === 0 ) {
            this.setState( { erroremail: true, } );
            return;
        }
        this.onStore();
    }
    onStore() {
        let body = {
            nombre: this.state.nombre,
            apellido: this.state.apellido,
            nit: this.state.nit,
            telefono: this.state.telefono,
            email: this.state.email,
            idcliente: this.props.params.idcliente,
        };
        this.setState( { disabled: true, } );
        axios.post( "/api/cliente/update", body ) . then ( ( resp ) => {
            console.log(resp)
            this.setState( { disabled: false, } );
            if ( resp.data.rpta === 1 ) {
                Swal.fire( {
                    position: 'top-end',
                    icon: 'success',
                    title: resp.data.message,
                    showConfirmButton: false,
                    timer: 1500
                } );
                this.props.navigate('/cliente/index');
                return;
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
            this.setState( { disabled: false, } );
        } );
    }
    render() {
        return (
            <>
                <Card title={"EDITAR CLIENTE"} bordered 
                    extra={ 
                        <Button type="primary" danger disabled={this.state.disabled}
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
                                onChange={this.onChangeNombre.bind(this)}
                                error={this.state.errornombre}
                                helperText={ this.state.errornombre && "Campo requerido." }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 16, } } >
                            <TextField
                                fullWidth
                                label="Apellido" size="small"
                                value={this.state.apellido}
                                onChange={this.onChangeApellido.bind(this)}
                                error={this.state.errorapellido}
                                helperText={ this.state.errorapellido && "Campo requerido." }
                            />
                        </Col>
                    </Row>
                    <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                        <Col xs={{ span: 24, }} sm={ { span: 6, } } >
                            <TextField
                                fullWidth
                                label="Nit" size="small"
                                value={this.state.nit}
                                onChange={this.onChangeNit.bind(this)}
                                error={this.state.errornit}
                                helperText={ this.state.errornit && "Campo requerido." }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 6, } } >
                            <TextField
                                fullWidth
                                label="Tèlefono" size="small"
                                value={this.state.telefono}
                                onChange={this.onChangeTelefono.bind(this)}
                                error={this.state.errortelefono}
                                helperText={ this.state.errortelefono && "Campo requerido." }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 12, } } >
                            <TextField
                                fullWidth
                                label="Email" size="small"
                                value={this.state.email}
                                onChange={this.onChangeEmail.bind(this)}
                                error={this.state.erroremail}
                                helperText={ this.state.erroremail && "Campo requerido." }
                            />
                        </Col>
                    </Row>
                    <Row gutter={[16, 24]} style={ { marginTop: 20,} } justify='center'>
                        <Button danger style={ { marginRight: 5, } }
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/cliente/index" );
                            } } disabled={this.state.disabled}
                        >
                            Cancelar
                        </Button>
                        <Button type="primary" danger disabled={this.state.disabled}
                            onClick={this.onValidate.bind(this)}
                        >
                            Actualizar
                        </Button>
                    </Row>
                </Card>
            </>
        );
    }
};

export default ClienteEdit;
