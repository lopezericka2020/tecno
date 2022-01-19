
import React, { Component } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Checkbox, Col, Row, Table } from 'antd';

import TextField from '@mui/material/TextField';
import Swal from 'sweetalert2';

function TerrenoShow() {
    const navigate = useNavigate();
    const params = useParams();
    return (
        <>
            <TerrenoShowPrivate 
                navigate={navigate}
                params={params}
            />
        </>
    );
};

class TerrenoShowPrivate extends Component {

    constructor( props) {
        super( props );
        this.state = {
            visible_store: false,
            loading: false,
            disabled: false,

            arrayFKIDServicio: [],

            descripcion: "",
            precio: "",
            ciudad: "",
            direccion: "",
            nota: "",
            nit: "",

            anticipo: "",
            nrocuota: "",
            tipopago: "",
            habilitarplandepago: false,

        };
        this.columnsServicio = [
            {
              title: 'Nro',
              dataIndex: 'nro',
              render: ( text, record, index ) => index + 1,
            },
            {
              title: 'Descripción',
              dataIndex: 'descripcion',
              key: 'descripcion',
            },
        ];
    };
    componentDidMount() {
        this.get_data();
    };
    get_data( ) {
        axios.get( "/api/terreno/show/" + this.props.params.idterreno ) . then ( ( resp ) => {
            console.log(resp)
            if ( resp.data.rpta === 1 ) {
                this.setState( {
                    descripcion: resp.data.terreno.descripcion ? resp.data.terreno.descripcion : "",
                    precio: resp.data.terreno.precio ? resp.data.terreno.precio : "",
                    ciudad: resp.data.terreno.ciudad ? resp.data.terreno.ciudad : "",
                    direccion: resp.data.terreno.direccion ? resp.data.terreno.direccion : "",
                    nota: resp.data.terreno.nota ? resp.data.terreno.nota : "",

                    anticipo: resp.data.plandepago ? resp.data.plandepago.anticipo : "",
                    nrocuota: resp.data.plandepago ? resp.data.plandepago.nrocuota : "",
                    tipopago: resp.data.plandepago ? resp.data.plandepago.tipopago : "",
                    habilitarplandepago: resp.data.plandepago ? true : false,

                    arrayFKIDServicio: resp.data.arrayTerrenoServicio,
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
                <Card title={"DETALLE TERRENO"} bordered 
                    extra={ 
                        <Button type="primary" danger
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/terreno/index" );
                            } }
                        >
                            Atras
                        </Button> 
                    }
                    style={{ minWidth: '100%', width: '100%', maxWidth: '100%', }}
                >
                    <Row gutter={[16, 24]}>
                        <Col sm={{ span: 2, }}></Col>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth
                                label="Descripción" size="small"
                                value={this.state.descripcion}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth
                                label="Precio" size="small"
                                value={this.state.precio}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                    </Row>
                    <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth
                                label="Ciudad" size="small"
                                value={this.state.ciudad}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 16, } } >
                            <TextField
                                fullWidth
                                label="Direcciòn" size="small"
                                value={this.state.direccion}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                    </Row>

                    <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                        <Col xs={{ span: 24, }} >
                            <Checkbox checked={this.state.habilitarplandepago} 
                                onChange={ (evt) => {
                                    this.setState( {
                                        habilitarplandepago: evt.target.checked,
                                    } );
                                } } disabled
                            >
                                Habilitar Plan de Pago
                            </Checkbox>
                        </Col>
                    </Row>

                    { this.state.habilitarplandepago &&
                        <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                            <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                                <TextField
                                    fullWidth
                                    label="Anticipo" size="small"
                                    value={this.state.anticipo}
                                    InputProps={ {
                                        readOnly: true,
                                    } }
                                />
                            </Col>
                            <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                                <TextField
                                    fullWidth
                                    label="Nro Cuota" size="small"
                                    value={this.state.nrocuota}
                                    InputProps={ {
                                        readOnly: true,
                                    } }
                                />
                            </Col>
                            <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                                <TextField
                                    fullWidth select focused
                                    label="Tipo" size="small"
                                    value={this.state.tipopago}
                                    InputProps={ {
                                        readOnly: true,
                                    } }
                                    SelectProps={ {
                                        native: true,
                                    } }
                                >
                                    <option value={ "" }>
                                        { "Seleccionar" }
                                    </option>
                                    <option value={ "Diario" }>
                                        { "Diario" }
                                    </option>
                                    <option value={ "Mensual" }>
                                        { "Mensual" }
                                    </option>
                                    <option value={ "Anual" }>
                                        { "Anual" }
                                    </option>
                                </TextField>
                            </Col>
                        </Row>
                    }

                    <Row gutter={[16, 24]} style={ { marginTop: 20, } }>
                        <Col xs={{ span: 24, }} >
                            <Table columns={this.columnsServicio} dataSource={this.state.arrayFKIDServicio} 
                                bordered style={ { width: '100%', minWidth: '100%', } } pagination={false}
                                size='small' rowKey={"idservicio"}
                                title={() => 'SERVICIOS DEL TERRENO'}
                            />
                        </Col>
                    </Row>

                    <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                        <Col xs={{ span: 24, }} sm={ { span: 24, } } >
                            <TextField
                                fullWidth multiline minRows={3}
                                label="Nota" size="small"
                                value={this.state.nota}
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

export default TerrenoShow;
