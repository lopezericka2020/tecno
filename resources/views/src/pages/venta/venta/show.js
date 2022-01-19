
import React, { Component } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Col, Image, Row, Table } from 'antd';

import TextField from '@mui/material/TextField';
import Swal from 'sweetalert2';

function VentaShow() {
    const navigate = useNavigate();
    const params = useParams();
    return (
        <>
            <VentaShowPrivate 
                navigate={navigate}
                params={params}
            />
        </>
    );
};

class VentaShowPrivate extends Component {

    constructor( props) {
        super( props );
        this.state = {
            visible_store: false,
            loading: false,
            disabled: false,

            arrayPlanDePago: [],
            arrayFKIDTerreno: [],
            arrayVentaDetalle: [],
            montototal: 0,

            nombre: "",
            apellido: "",
            telefono: "",
            email: "",
            ciudad: "",
            direccion: "",
            nit: "",
            tipopago: "",

            nota: "",
        };
        this.columnsPlanPago = [
            {
              title: 'Nro',
              dataIndex: 'nrocuota',
              key: "nrocuota"
            },
            {
              title: 'Fecha a Pagar',
              dataIndex: 'fechaapagar',
              key: 'fechaapagar',
            },
            {
                title: 'Monto a Pagar',
                dataIndex: 'montoapagar',
                key: 'montoapagar',
            },
        ];
    };
    componentDidMount() {
        this.get_data();
    };
    get_data( ) {
        axios.get( "/api/venta/show/" + this.props.params.idventa ) . then ( ( resp ) => {
            console.log(resp)
            if ( resp.data.rpta === 1 ) {
                this.setState( {
                    nombre: resp.data.venta.nombre,
                    apellido: resp.data.venta.apellido,
                    telefono: resp.data.venta.telefono,
                    email: resp.data.venta.email,
                    ciudad: resp.data.venta.ciudad,
                    direccion: resp.data.venta.direccion,
                    arrayFKIDTerreno: resp.data.venta.arrayVentaDetalle,
                    nota: resp.data.venta.nota ? resp.data.venta.nota : "",
                    nit: resp.data.venta.nit ? resp.data.venta.nit : "",
                    tipopago: resp.data.venta.tipopago ? resp.data.venta.tipopago : "",

                    arrayVentaDetalle: resp.data.arrayVentaDetalle,
                    arrayPlanDePago: resp.data.arrayPlanPago,
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
                <Card title={"DETALLE VENTA"} bordered 
                    extra={ 
                        <Button type="primary" danger
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/venta/index" );
                            } }
                        >
                            Atras
                        </Button> 
                    }
                    style={{ minWidth: '100%', width: '100%', maxWidth: '100%', }}
                >

                    <Row gutter={[16, 24]}>
                        <Col xs={{ span: 24, }} sm={ { span: 10, } } >
                            <TextField
                                fullWidth
                                label="Cliente" size="small"
                                value={this.state.nombre + " " + this.state.apellido }
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
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
                                label="Tipo Pago" size="small"
                                value={this.state.tipopago}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                    </Row>

                    <Row gutter={[16, 24]} style={ { marginTop: 20, border: '1px solid #e8e8e8', paddingTop: 8, paddingBottom: 8, } }>
                        <Col xs={{ span: 24, }} sm={ { span: 20, } } >
                            <TextField
                                fullWidth
                                label="Terreno" size="small"
                                value={ this.state.arrayVentaDetalle.length>0?this.state.arrayVentaDetalle[0].descripcion:"" }
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 4, } } >
                            <TextField
                                fullWidth
                                label="Precio" size="small"
                                value={this.state.arrayVentaDetalle.length>0?this.state.arrayVentaDetalle[0].precio:""}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                    </Row>

                    <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                        <Col xs={{ span: 24, }} sm={ { span: 24, } } >
                            <TextField
                                fullWidth
                                label="Direccion del Terreno" size="small"
                                value={this.state.arrayVentaDetalle.length>0?this.state.arrayVentaDetalle[0].ciudad+" "+this.state.arrayVentaDetalle[0].direccion:""}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                    </Row>

                    <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                        <Col xs={{ span: 24, }} sm={ { span: 24, } } style={{ textAlign: 'center', }}>
                            <Image
                                width={200}
                                src={ this.state.arrayVentaDetalle.length>0?this.state.arrayVentaDetalle[0].imagen:"" }
                                style={{ margin: 'auto', }}
                            />
                        </Col>
                    </Row>

                    <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth
                                label="Anticipo" size="small"
                                value={this.state.arrayVentaDetalle.length>0?this.state.arrayVentaDetalle[0].anticipo:""}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth
                                label="Nro Cuota" size="small"
                                value={this.state.arrayVentaDetalle.length>0?this.state.arrayVentaDetalle[0].nrocuota:""}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth
                                label="Tipo" size="small"
                                value={this.state.arrayVentaDetalle.length>0?this.state.arrayVentaDetalle[0].tipopago:""}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                    </Row>

                    <Row gutter={[16, 24]} style={ { marginTop: 20, } }>
                        <Col xs={{ span: 24, }} >
                            <Table columns={this.columnsPlanPago} dataSource={this.state.arrayPlanDePago} 
                                bordered style={ { width: '100%', minWidth: '100%', } } pagination={false}
                                size='small' rowKey={"nro"} scroll={{ x: '100%', y: 300, }}
                                title={() => 'DETALLE PLAN DE PAGO'}
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

export default VentaShow;
