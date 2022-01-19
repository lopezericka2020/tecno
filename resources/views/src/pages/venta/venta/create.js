
import React, { Component } from 'react';
import { useNavigate } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Col, Image, Row, Table, Tooltip, Typography } from 'antd';
const { Text } = Typography;

import TextField from '@mui/material/TextField';
import Swal from 'sweetalert2';
import { CloseOutlined } from '@ant-design/icons';

function VentaCreate() {
    const navigate = useNavigate();
    return (
        <>
            <VentaCreatePrivate 
                navigate={navigate}
            />
        </>
    );
};

class VentaCreatePrivate extends Component {

    constructor( props) {
        super( props );
        this.state = {
            visible_store: false,
            loading: false,
            disabled: false,

            arrayTerreno: [],
            arrayFKIDTerreno: [],
            fkidterreno: "",
            precio: "",
            cantidad: "",
            imagen: "",
            lugar: "",
            montototal: 0,

            arrayCliente: [],
            fkidcliente: "",
            nombre: "",
            apellido: "",
            telefono: "",
            email: "",
            ciudad: "",
            direccion: "",
            nit: "",
            tipopago: "Contado",

            nota: "",

            nrocuota: "",
            anticipo: "",
            tipoplandepago: "",
            idplandepago: "",
            arrayPlanDePago: [],

            errordescripcion: false,
            errorfkidcliente: false,
            errorciudad: false,
            errordireccion: false,
            errornit: false,
            errorfkidterreno: false,
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
            {
                title: 'Cantidad',
                dataIndex: 'cantidad',
                key: 'cantidad',
            },
            {
                title: 'Precio',
                dataIndex: 'precio',
                key: 'precio',
            },
            {
                title: 'Acción',
                dataIndex: 'accion',
                render: (text, record) => {
                    return (
                        <>
                            <Tooltip title="Quitar">
                                <Button shape="circle" style={ { marginRight: 5, } }
                                    icon={<CloseOutlined style={ { position: 'relative', top: -2, } } />} 
                                    onClick={ ( evt ) => {
                                        evt.preventDefault();
                                        // this.props.navigate( "/medico/edit/" + record.medico.idmedico );
                                        this.state.arrayFKIDTerreno = this.state.arrayFKIDTerreno.filter( ( item ) => ( item.idterreno != record.idterreno ) );
                                        this.setState( {
                                            arrayFKIDTerreno: this.state.arrayFKIDTerreno,
                                        } );
                                    } }
                                />
                            </Tooltip>
                        </>
                    )
                },
            }
        ];

        this.columnsPlanPago = [
            {
              title: 'Nro',
              dataIndex: 'nro',
            },
            {
              title: 'Fecha a Pagar',
              dataIndex: 'fecha',
              key: 'fecha',
            },
            {
                title: 'Monto a Pagar',
                dataIndex: 'monto',
                key: 'monto',
            },
        ];

    };
    componentDidMount() {
        this.get_data();
    };
    get_data( ) {
        axios.get( "/api/venta/create" ) . then ( ( resp ) => {
            console.log(resp)
            if ( resp.data.rpta === 1 ) {
                
                this.setState( {
                    arrayCliente: resp.data.arrayCliente,
                    arrayTerreno: resp.data.arrayTerreno,
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

    onChangeNota( evt ) {
        this.setState( {
            nota: evt.target.value,
            errordescripcion: false,
        } );
    };

    onChangeNit( evt ) {
        this.setState( {
            nit: evt.target.value,
            errornit: false,
        } );
    };

    onChangeCiudad( evt ) {
        this.setState( {
            ciudad: evt.target.value,
            errorciudad: false,
        } );
    };

    onChangeDireccion( evt ) {
        this.setState( {
            direccion: evt.target.value,
            errordireccion: false,
        } );
    };
    onChangeTipoPago( evt ) {
        this.setState( {
            tipopago: evt.target.value,
        } );
    };

    showCliente( fkidcliente ) {
        for (let index = 0; index < this.state.arrayCliente.length; index++) {
            const element = this.state.arrayCliente[index];
            if ( element.idcliente == fkidcliente ) {
                return element;
            };
        }
        return null;
    };

    onChangeFKIDCliente( evt ) {
        const element = this.showCliente( evt.target.value );
        this.setState( {
            fkidcliente: evt.target.value,
            nombre: element ? element.nombre: "",
            apellido: element ? element.apellido: "",
            telefono: element ? element.telefono: "",
            email: element ? element.email: "",
            nit: element ? element.nit: "",
            errorfkidcliente: false,
        } );
    };

    onChangeFKIDTerreno( evt ) {
        const element = this.showTerreno( evt.target.value );
        console.log(element)
        this.setState( {
            fkidterreno: evt.target.value,
            cantidad: element ? 1 : "",
            precio: element ? element.precio: 0,
            imagen: element ? element.imagen: "",
            lugar: element ? element.ciudad + " " + element.direccion: "",

            anticipo: element ? element.anticipo: "",
            nrocuota: element ? element.nrocuota: "",
            idplandepago: element ? element.idplandepago: "",
            tipoplandepago: element ? element.tipopago: "",
            
            errorfkidterreno: false,
        }, () => {
            if ( element ) {
                let montototal = this.state.precio * 1 - element.anticipo * 1;
                let date = new Date();
                for (let index = 0; index < element.nrocuota * 1; index++) {
                    if ( element.tipopago === "Mensual" ) {
                        date.setMonth( date.getMonth() + 1 );
                    }
                    if ( element.tipopago === "Anual" ) {
                        date.setFullYear( date.getFullYear() + 1 );
                    }
                    if ( element.tipopago === "Diario" ) {
                        date.setDate( date.getDate() + 1 );
                    }
                    let day = date.getDate();
                    let mounth = date.getMonth() + 1;
                    let year = date.getFullYear();
                    day = day < 10 ? '0' + day : day;
                    mounth = mounth < 10 ? '0' + mounth : mounth;
                    const detalle = {
                        nro: index + 1,
                        fecha: day + "/" + mounth + "/" + year,
                        monto: montototal / element.nrocuota * 1,
                    };
                    this.state.arrayPlanDePago = [ ...this.state.arrayPlanDePago, detalle ];
                }
                this.setState( {
                    arrayPlanDePago: this.state.arrayPlanDePago,
                } );
            }
        } );
    };
    onChangePrecio( evt ) {
        if ( evt.target.value === "" ) {
            this.setState( {
                precio: "",
            } );
            return;
        }
        if ( !isNaN( evt.target.value ) ) {
            this.setState( {
                precio: evt.target.value,
            } );
        }
    };
    onChangeCantidad( evt ) {
        if ( evt.target.value === "" ) {
            this.setState( {
                cantidad: "",
            } );
            return;
        }
        if ( !isNaN( evt.target.value ) ) {
            this.setState( {
                cantidad: evt.target.value,
            } );
        }
    };

    showTerreno( fkidterreno ) {
        for (let index = 0; index < this.state.arrayTerreno.length; index++) {
            const element = this.state.arrayTerreno[index];
            if ( element.idterreno == fkidterreno ) {
                return element;
            };
        }
        return null;
    };
    onAgregarServicio() {
        if ( this.state.fkidterreno === "" || this.state.precio === "" || this.state.cantidad === "" || parseFloat( this.state.precio ) <= 0 || parseFloat( this.state.cantidad ) <= 0 ) {
            Swal.fire( {
                position: 'top-end',
                icon: 'warning',
                title: "Favor de seleccionar Terreno o cantidad o precio mayor a 0.",
                showConfirmButton: false,
                timer: 1500
            } );
            return;
        }
        const element = this.showTerreno( this.state.fkidterreno );
        const detalle = {
            descripcion: element.descripcion,
            precio: this.state.precio,
            cantidad: this.state.cantidad,
            idterreno: element.idterreno,
        };
        this.state.arrayFKIDTerreno = [ ...this.state.arrayFKIDTerreno, detalle ];
        this.setState( {
            arrayFKIDTerreno: this.state.arrayFKIDTerreno,
            fkidterreno: "",
            cantidad: "",
            precio: "",
        }, () => {
            let montototal = 0;
            for (let index = 0; index < this.state.arrayFKIDTerreno.length; index++) {
                const element = this.state.arrayFKIDTerreno[index];
                montototal += parseFloat( element.cantidad * element.precio )
            }
            this.setState( {
                montototal: montototal,
            } );
        } );
    }

    onValidate() {
        if ( this.state.fkidcliente.toString().trim().length === 0 ) {
            this.setState( { errorfkidcliente: true, } );
            return;
        }
        if ( this.state.nit.toString().trim().length === 0 ) {
            this.setState( { errornit: true, } );
            return;
        }
        if ( this.state.fkidterreno.toString().trim().length === 0 ) {
            this.setState( { errorfkidterreno: true, } );
            return;
        }
        this.onStore();
    }
    getDate() {
        let date = new Date();
        let year = date.getFullYear();
        let mounth = date.getMonth() + 1;
        let day = date.getDate();
        return year + "-" + mounth + '-' + day;
    }
    getTime() {
        let date = new Date();
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let seconds = date.getSeconds();
        hours = hours > 9 ? hours : '0' + hours;
        minutes = minutes > 9 ? minutes : '0' + minutes;
        seconds = seconds > 9 ? seconds : '0' + seconds;
        return hours + ':' + minutes + ':' + seconds;
    }
    arrayFKIDTerreno() {
        const detalle = {
            precio: this.state.precio,
            cantidad: 1,
            idterreno: this.state.fkidterreno,
        };
        let arrayFKIDTerreno = [ ];
        arrayFKIDTerreno = [ ...arrayFKIDTerreno, detalle ];
        return arrayFKIDTerreno;
    };
    onStore() {
        let body = {
            fkidcliente: this.state.fkidcliente,
            nombre: this.state.nombre,
            apellido: this.state.apellido,
            telefono: this.state.telefono,
            email: this.state.email,
            ciudad: this.state.ciudad,
            direccion: this.state.direccion,
            nit: this.state.nit,
            nota: this.state.nota,
            tipopago: this.state.tipopago,
            montototal: this.state.precio,
            idplandepago: this.state.idplandepago,
            arrayFKIDTerreno: JSON.stringify( this.arrayFKIDTerreno() ),
            arrayPlanDePago: JSON.stringify( this.state.arrayPlanDePago ),
            x_fecha: this.getDate(),
            x_hora: this.getTime(),
        };
        this.setState( { disabled: true, } );
        axios.post( "/api/venta/store", body ) . then ( ( resp ) => {
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
                this.props.navigate('/venta/index');
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
                <Card title={"NUEVA VENTA"} bordered 
                    extra={ 
                        <Button type="primary" danger disabled={this.state.disabled}
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
                                fullWidth select focused
                                label="Cliente" size="small"
                                value={this.state.fkidcliente}
                                onChange={this.onChangeFKIDCliente.bind(this)}
                                error={this.state.errorfkidcliente}
                                helperText={ this.state.errorfkidcliente && "Campo requerido." }
                                SelectProps={ {
                                    native: true,
                                } }
                            >
                                <option value={""}>Ninguno</option>
                                { this.state.arrayCliente.map( ( item, index ) => {
                                    return (
                                        <option key={index} value={ item.idcliente }>
                                            { item.nombre + " " + item.apellido }
                                        </option>
                                    );
                                } ) }
                            </TextField>
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
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
                                    fullWidth select focused
                                    label="Tipo Pago" size="small"
                                    value={this.state.tipopago}
                                    onChange={this.onChangeTipoPago.bind(this)}
                                    SelectProps={ {
                                        native: true,
                                    } }
                                >
                                    <option value={ "Contado" }>
                                        { "Contado" }
                                    </option>
                                    <option value={ "Credito" }>
                                        { "Credito" }
                                    </option>
                                </TextField>
                            </Col>
                    </Row>

                    <Row gutter={[16, 24]} style={ { marginTop: 20, border: '1px solid #e8e8e8', paddingTop: 8, paddingBottom: 8, } }>
                        <Col xs={{ span: 24, }} sm={ { span: 20, } } >
                            <TextField
                                fullWidth select focused
                                label="Terreno" size="small"
                                value={this.state.fkidterreno}
                                onChange={this.onChangeFKIDTerreno.bind(this)}
                                SelectProps={ {
                                    native: true,
                                } }
                                error={this.state.errorfkidterreno}
                                helperText={ this.state.errorfkidterreno && "Campo requerido." }
                            >
                                <option value={""}>Ninguno</option>
                                { this.state.arrayTerreno.map( ( item, index ) => {
                                    return (
                                        <option key={index} value={ item.idterreno }>
                                            { item.descripcion }
                                        </option>
                                    );
                                } ) }
                            </TextField>
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 4, } } >
                            <TextField
                                fullWidth
                                label="Precio" size="small"
                                value={this.state.precio}
                                onChange={this.onChangePrecio.bind(this)}
                                disabled={ this.state.fkidterreno === "" ? true : false }
                            />
                        </Col>
                        {/* <Col xs={{ span: 24, }} sm={ { span: 4, } } >
                            <TextField
                                fullWidth
                                label="Cantidad" size="small"
                                value={this.state.cantidad}
                                onChange={this.onChangeCantidad.bind(this)}
                                disabled={ this.state.fkidterreno === "" ? true : false }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 4, } } >
                            <Button type="primary" danger disabled={this.state.disabled}
                                style={ { position: 'relative', top: 5, } } onClick={this.onAgregarServicio.bind(this)}
                            >
                                Agregar
                            </Button>
                        </Col> */}
                    </Row>
                    <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                        <Col xs={{ span: 24, }} sm={ { span: 24, } } >
                            <TextField
                                fullWidth
                                label="Direccion del Terreno" size="small"
                                value={this.state.lugar}
                                InputProps={ {
                                    readOnly: true,
                                } }
                            />
                        </Col>
                    </Row>

                    { this.state.imagen !== "" && 
                        <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                            <Col xs={{ span: 24, }} sm={ { span: 24, } } style={{ textAlign: 'center', }}>
                                <Image
                                    width={200}
                                    src={ this.state.imagen }
                                    style={{ margin: 'auto', }}
                                />
                            </Col>
                        </Row>
                    }

                    {/* <Row gutter={[16, 24]} style={ { marginTop: 20, } }>
                        <Col xs={{ span: 24, }} >
                            <Table columns={this.columnsServicio} dataSource={this.state.arrayFKIDTerreno} 
                                bordered style={ { width: '100%', minWidth: '100%', } } pagination={false}
                                size='small' rowKey={"idterreno"}
                                title={() => 'DETALLE DE VENTA'}
                                summary={ pageData => {
                            
                                    return (
                                      <>
                                        <Table.Summary.Row>
                                          <Table.Summary.Cell colSpan={3}>Total</Table.Summary.Cell>
                                          <Table.Summary.Cell>
                                            <Text>{this.state.montototal}</Text>
                                          </Table.Summary.Cell>
                                        </Table.Summary.Row>
                                      </>
                                    );
                                } }
                            />
                        </Col>
                    </Row> */}

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
                                fullWidth
                                label="Tipo" size="small"
                                value={this.state.tipoplandepago}
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
                                onChange={this.onChangeNota.bind(this)}
                            />
                        </Col>
                    </Row>

                    <Row gutter={[16, 24]} style={ { marginTop: 20,} } justify='center'>
                        <Button danger style={ { marginRight: 5, } }
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/venta/index" );
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

export default VentaCreate;
