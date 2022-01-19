
import React, { Component } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Col, Row } from 'antd';

import TextField from '@mui/material/TextField';
import Swal from 'sweetalert2';

function ServicioEdit() {
    const navigate = useNavigate();
    const params = useParams();
    return (
        <>
            <ServicioEditPrivate 
                navigate={navigate}
                params={params}
            />
        </>
    );
};

class ServicioEditPrivate extends Component {

    constructor( props) {
        super( props );
        this.state = {
            visible_store: false,
            loading: false,
            disabled: false,

            descripcion: "",

            errordescripcion: false,
        };
    };
    componentDidMount() {
        this.get_data();
    };
    get_data( ) {
        axios.get( "/api/servicio/edit/" + this.props.params.idservicio ) . then ( ( resp ) => {
            console.log(resp)
            if ( resp.data.rpta === 1 ) {
                this.setState( {
                    descripcion: resp.data.servicio.descripcion,
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
    onChangeDescripcion( evt ) {
        this.setState( {
            descripcion: evt.target.value,
            errordescripcion: false,
        } );
    };
    onValidate() {
        if ( this.state.descripcion.toString().trim().length === 0 ) {
            this.setState( { errordescripcion: true, } );
            return;
        }
        this.onStore();
    }
    onStore() {
        let body = {
            descripcion: this.state.descripcion,
            idservicio: this.props.params.idservicio,
        };
        this.setState( { disabled: true, } );
        axios.post( "/api/servicio/update", body ) . then ( ( resp ) => {
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
                this.props.navigate('/servicio/index');
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
                <Card title={"EDITAR SERVICIO"} bordered 
                    extra={ 
                        <Button type="primary" danger disabled={this.state.disabled}
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/servicio/index" );
                            } }
                        >
                            Atras
                        </Button> 
                    }
                    style={{ minWidth: '100%', width: '100%', maxWidth: '100%', }}
                >
                    <Row gutter={[16, 24]}>
                        <Col sm={{ span: 8, }}></Col>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth
                                label="Descripción" size="small"
                                value={this.state.descripcion}
                                onChange={this.onChangeDescripcion.bind(this)}
                                error={this.state.errordescripcion}
                                helperText={ this.state.errordescripcion && "Campo requerido." }
                            />
                        </Col>
                    </Row>
                    <Row gutter={[16, 24]} style={ { marginTop: 20,} } justify='center'>
                        <Button danger style={ { marginRight: 5, } }
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/servicio/index" );
                            } } disabled={this.state.disabled}
                        >
                            Cancelar
                        </Button>
                        <Button type="primary" danger disabled={this.state.disabled}
                            onClick={this.onValidate.bind(this)}
                        >
                            Guardar
                        </Button>
                    </Row>
                </Card>
            </>
        );
    }
};

export default ServicioEdit;
