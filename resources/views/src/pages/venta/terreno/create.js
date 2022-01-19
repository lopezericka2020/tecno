
import React, { Component } from 'react';
import { useNavigate } from 'react-router-dom';

import axios from 'axios';
import { Button, Card, Checkbox, Col, Row, Table, Tooltip } from 'antd';

import TextField from '@mui/material/TextField';
import Swal from 'sweetalert2';
import { CloseOutlined } from '@ant-design/icons';
import { CheckBoxOutlined } from '@mui/icons-material';

function TerrenoCreate() {
    const navigate = useNavigate();
    return (
        <>
            <TerrenoCreatePrivate 
                navigate={navigate}
            />
        </>
    );
};

class TerrenoCreatePrivate extends Component {

    constructor( props) {
        super( props );
        this.state = {
            visible_store: false,
            loading: false,
            disabled: false,

            arrayServicio: [],
            arrayFKIDServicio: [],
            fkidservicio: "",

            descripcion: "",
            precio: "",
            ciudad: "",
            direccion: "",
            nota: "",
            imagen: "",

            anticipo: "",
            nrocuota: "",
            tipopago: "",
            habilitarplandepago: false,

            errordescripcion: false,
            errorprecio: false,
            errorciudad: false,
            errordireccion: false,
            errornota: false,

            erroranticipo: false,
            errornrocuota: false,
            errortipopago: false,
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
                                        this.state.arrayFKIDServicio = this.state.arrayFKIDServicio.filter( ( item ) => ( item.idservicio != record.idservicio ) );
                                        this.setState( {
                                            arrayFKIDServicio: this.state.arrayFKIDServicio,
                                        } );
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
    get_data( ) {
        axios.get( "/api/terreno/create" ) . then ( ( resp ) => {
            console.log(resp)
            if ( resp.data.rpta === 1 ) {
                
                this.setState( {
                    arrayServicio: resp.data.arrayservicio,
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

    onChangeAnticipo( evt ) {
        if ( evt.target.value === "" ) {
            this.setState( {
                anticipo: evt.target.value,
                errordescripcion: false,
            } );
            return;
        }
        if ( !isNaN( evt.target.value ) ) {
            this.setState( {
                anticipo: evt.target.value,
                errordescripcion: false,
            } );
        }
    };
    onChangeNroCuota( evt ) {
        if ( evt.target.value === "" ) {
            this.setState( {
                nrocuota: evt.target.value,
                errornrocuota: false,
            } );
            return;
        }
        if ( !isNaN( evt.target.value ) ) {
            this.setState( {
                nrocuota: evt.target.value,
                errornrocuota: false,
            } );
        }
    };
    onChangeTipoPago( evt ) {
        this.setState( {
            tipopago: evt.target.value,
            errortipopago: false,
        } );
    };

    onChangeDescripcion( evt ) {
        this.setState( {
            descripcion: evt.target.value,
            errordescripcion: false,
        } );
    };
    onChangePrecio( evt ) {
        if ( evt.target.value === "" ) {
            this.setState( {
                precio: evt.target.value,
                errorprecio: false,
            } );
            return;
        }
        if ( !isNaN( evt.target.value ) ) {
            this.setState( {
                precio: evt.target.value,
                errorprecio: false,
            } );
        }
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
    onChangeNota( evt ) {
        this.setState( {
            nota: evt.target.value,
            errornota: false,
        } );
    };
    onChangeImagen( evt ) {
        let file = evt.target.files;
        if ( file[0].type === "image/png" || file[0].type === "image/jpg" || file[0].type === "image/jpeg" || file[0].type === "image/bmp" ) {
            let reader = new FileReader();
            reader.onload = ( evt ) => {
                console.log(evt)
                this.setState( {
                    imagen: evt.target.result,
                } );
            };
            reader.readAsDataURL( evt.target.files[0] );
            return;
        }
    };

    onChangeFKIDServicio( evt ) {
        this.setState( {
            fkidservicio: evt.target.value,
        } );
    };

    existeServicio( fkidservicio ) {
        for (let index = 0; index < this.state.arrayFKIDServicio.length; index++) {
            const element = this.state.arrayFKIDServicio[index];
            if ( element.idservicio == fkidservicio ) {
                return true;
            };
        }
        return false;
    };
    showServicio( fkidservicio ) {
        for (let index = 0; index < this.state.arrayServicio.length; index++) {
            const element = this.state.arrayServicio[index];
            if ( element.idservicio == fkidservicio ) {
                return element;
            };
        }
        return null;
    };
    onAgregarServicio() {
        if ( this.state.fkidservicio === "" ) {
            Swal.fire( {
                position: 'top-end',
                icon: 'warning',
                title: "Favor de seleccionar Servicio.",
                showConfirmButton: false,
                timer: 1500
            } );
            return;
        }
        if ( this.existeServicio( this.state.fkidservicio ) ) {
            Swal.fire( {
                position: 'top-end',
                icon: 'warning',
                title: "Servicio ya seleccionado.",
                showConfirmButton: false,
                timer: 1500
            } );
            return;
        }
        const element = this.showServicio( this.state.fkidservicio );
        const detalle = {
            descripcion: element.descripcion,
            idservicio: element.idservicio,
        };
        this.state.arrayFKIDServicio = [ ...this.state.arrayFKIDServicio, detalle ];
        this.setState( {
            arrayFKIDServicio: this.state.arrayFKIDServicio,
            fkidservicio: "",
        } );
    }

    onValidate() {
        if ( this.state.descripcion.toString().trim().length === 0 ) {
            this.setState( { errordescripcion: true, } );
            return;
        }
        if ( this.state.ciudad.toString().trim().length === 0 ) {
            this.setState( { errorciudad: true, } );
            return;
        }
        if ( this.state.direccion.toString().trim().length === 0 ) {
            this.setState( { errordireccion: true, } );
            return;
        }
        if ( this.state.precio.toString().trim().length === 0 ) {
            this.setState( { errorprecio: true, } );
            return;
        }
        if ( this.state.precio <= 0 ) {
            this.setState( { errorprecio: true, } );
            return;
        }
        if ( this.state.habilitarplandepago ) {
            if ( this.state.anticipo.toString().trim().length === 0 ) {
                this.setState( { erroranticipo: true, } );
                return;
            }
            if ( this.state.anticipo <= 0 ) {
                this.setState( { erroranticipo: true, } );
                return;
            }
            if ( this.state.nrocuota.toString().trim().length === 0 ) {
                this.setState( { errornrocuota: true, } );
                return;
            }
            if ( this.state.nrocuota <= 0 ) {
                this.setState( { errornrocuota: true, } );
                return;
            }
            if ( this.state.tipopago.toString().trim().length === 0 ) {
                this.setState( { errortipopago: true, } );
                return;
            }
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
    onStore() {
        let body = {
            descripcion: this.state.descripcion,
            precio: this.state.precio,
            ciudad: this.state.ciudad,
            direccion: this.state.direccion,
            nota: this.state.nota,
            imagen: this.state.imagen,
            anticipo: this.state.anticipo,
            nrocuota: this.state.nrocuota,
            tipopago: this.state.tipopago,
            habilitarplandepago: this.state.habilitarplandepago ? 'A' : 'N',
            x_fecha: this.getDate(),
            x_hora: this.getTime(),
            arrayFKIDServicio: JSON.stringify( this.state.arrayFKIDServicio ),
        };
        this.setState( { disabled: true, } );
        axios.post( "/api/terreno/store", body ) . then ( ( resp ) => {
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
                this.props.navigate('/terreno/index');
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
                <Card title={"NUEVO TERRENO"} bordered 
                    extra={ 
                        <Button type="primary" danger disabled={this.state.disabled}
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
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth
                                label="Precio" size="small"
                                value={this.state.precio}
                                onChange={this.onChangePrecio.bind(this)}
                                error={this.state.errorprecio}
                                helperText={ this.state.errorprecio && "Campo requerido tipo númerico y mayor a 0." }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth type={"file"} focused
                                label="Imagen" size="small"
                                // value={this.state.precio}
                                InputProps={ {
                                    readOnly: true,
                                    endAdornment: this.state.imagen !== "" && <CheckBoxOutlined />
                                } }
                                onChange={this.onChangeImagen.bind(this)}
                                
                            />
                        </Col>
                    </Row>
                    <Row gutter={[16, 24]} style={ { marginTop: 20,} }>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth
                                label="Ciudad" size="small"
                                value={this.state.ciudad}
                                onChange={this.onChangeCiudad.bind(this)}
                                error={this.state.errorciudad}
                                helperText={ this.state.errorciudad && "Campo requerido." }
                            />
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 16, } } >
                            <TextField
                                fullWidth
                                label="Direcciòn" size="small"
                                value={this.state.direccion}
                                onChange={this.onChangeDireccion.bind(this)}
                                error={this.state.errordireccion}
                                helperText={ this.state.errordireccion && "Campo requerido." }
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
                                } }
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
                                    onChange={this.onChangeAnticipo.bind(this)}
                                    error={this.state.erroranticipo}
                                    helperText={ this.state.erroranticipo && "Campo requerido." }
                                />
                            </Col>
                            <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                                <TextField
                                    fullWidth
                                    label="Nro Cuota" size="small"
                                    value={this.state.nrocuota}
                                    onChange={this.onChangeNroCuota.bind(this)}
                                    error={this.state.errornrocuota}
                                    helperText={ this.state.errornrocuota && "Campo requerido." }
                                />
                            </Col>
                            <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                                <TextField
                                    fullWidth select focused
                                    label="Tipo" size="small"
                                    value={this.state.tipopago}
                                    onChange={this.onChangeTipoPago.bind(this)}
                                    error={this.state.errortipopago}
                                    helperText={ this.state.errortipopago && "Campo requerido." }
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
                
                    <Row gutter={[16, 24]} style={ { marginTop: 20, border: '1px solid #e8e8e8', paddingTop: 8, paddingBottom: 8, } }>
                        <Col xs={{ span: 24, }} sm={ { span: 12, } } ></Col>
                        <Col xs={{ span: 24, }} sm={ { span: 8, } } >
                            <TextField
                                fullWidth select focused
                                label="Servicio" size="small"
                                value={this.state.fkidservicio}
                                onChange={this.onChangeFKIDServicio.bind(this)}
                                SelectProps={ {
                                    native: true,
                                } }
                            >
                                <option value={""}>Ninguno</option>
                                { this.state.arrayServicio.map( ( item, index ) => {
                                    return (
                                        <option key={index} value={ item.idservicio }>
                                            { item.descripcion }
                                        </option>
                                    );
                                } ) }
                            </TextField>
                        </Col>
                        <Col xs={{ span: 24, }} sm={ { span: 4, } } >
                            <Button type="primary" danger disabled={this.state.disabled}
                                style={ { position: 'relative', top: 5, } } onClick={this.onAgregarServicio.bind(this)}
                            >
                                Agregar
                            </Button>
                        </Col>
                    </Row>
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
                                onChange={this.onChangeNota.bind(this)}
                                error={this.state.errornota}
                                helperText={ this.state.errornota && "Campo requerido." }
                            />
                        </Col>
                    </Row>

                    <Row gutter={[16, 24]} style={ { marginTop: 20,} } justify='center'>
                        <Button danger style={ { marginRight: 5, } }
                            onClick={ ( evt ) => {
                                evt.preventDefault();
                                this.props.navigate( "/terreno/index" );
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

export default TerrenoCreate;
