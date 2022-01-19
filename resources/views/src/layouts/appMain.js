
import React, { Component } from 'react';
import { Routes, Route } from 'react-router-dom';

import Header from './header';
import Sidebar from './sidebar';

import Home from '../home';

import PlanCuentaIndex from '../pages/plancuenta';

import GrupoUsuarioIndex from '../pages/seguridad/grupousuario';
import GrupoUsuarioCreate from '../pages/seguridad/grupousuario/create';
import GrupoUsuarioEdit from '../pages/seguridad/grupousuario/edit';
import GrupoUsuarioShow from '../pages/seguridad/grupousuario/show';

import FormularioIndex from '../pages/seguridad/formulario';
import FormularioCreate from '../pages/seguridad/formulario/create';
import FormularioEdit from '../pages/seguridad/formulario/edit';
import FormularioShow from '../pages/seguridad/formulario/show';

import UsuarioIndex from '../pages/seguridad/usuario';
import UsuarioCreate from '../pages/seguridad/usuario/create';
import UsuarioEdit from '../pages/seguridad/usuario/edit';
import UsuarioShow from '../pages/seguridad/usuario/show';

import AsignarUsuario from '../pages/seguridad/asignarusuario';
import AsignarFormulario from '../pages/seguridad/asignarformulario';

import ClienteIndex from '../pages/venta/cliente';
import ClienteCreate from '../pages/venta/cliente/create';
import ClienteEdit from '../pages/venta/cliente/edit';
import ClienteShow from '../pages/venta/cliente/show';

import TerrenoIndex from '../pages/venta/terreno';
import TerrenoCreate from '../pages/venta/terreno/create';
import TerrenoEdit from '../pages/venta/terreno/edit';
import TerrenoShow from '../pages/venta/terreno/show';
import ProveedorIndex from '../pages/compra/proveedor';
import ProveedorCreate from '../pages/compra/proveedor/create';
import ProveedorEdit from '../pages/compra/proveedor/edit';
import ProveedorShow from '../pages/compra/proveedor/show';

import ServicioIndex from '../pages/venta/servicio';
import ServicioCreate from '../pages/venta/servicio/create';
import ServicioEdit from '../pages/venta/servicio/edit';
import ServicioShow from '../pages/venta/servicio/show';

import VentaIndex from '../pages/venta/venta';
import VentaCreate from '../pages/venta/venta/create';
import VentaShow from '../pages/venta/venta/show';

function AppMain() {
    return (
        <AppMainPrivate />
    );
};

class AppMainPrivate extends Component {

    constructor( props ) {
        super( props );
        this.state = {};
    };
    componentDidMount() {
        this.get_data();
    };
    get_data() {};

    render() {
        return (
            <div id="pcoded" className="pcoded">
                <div className="pcoded-overlay-box"></div>
                <div className="pcoded-container navbar-wrapper">

                    <Header />

                    <div className="pcoded-main-container">
                        <div className="pcoded-wrapper">
                            
                            <Sidebar />
                            
                            <div className="pcoded-content">
                                <div className="pcoded-inner-content">
                                    <div className="main-body">
                                        <div className="page-wrapper">
                                            
                                            <Routes>
                                                <Route path="/plancuenta/index" element={ <PlanCuentaIndex /> } />
                                                <Route path="/plancuentatipo/index" element={ <Home /> } />


                                                <Route path="/cliente/index" element={ <ClienteIndex /> } />
                                                <Route path="/cliente/create" element={ <ClienteCreate /> } />
                                                <Route path="/cliente/edit/:idcliente" element={ <ClienteEdit /> } />
                                                <Route path="/cliente/show/:idcliente" element={ <ClienteShow /> } />

                                                <Route path="/terreno/index" element={ <TerrenoIndex /> } />
                                                <Route path="/terreno/create" element={ <TerrenoCreate /> } />
                                                <Route path="/terreno/edit/:idterreno" element={ <TerrenoEdit /> } />
                                                <Route path="/terreno/show/:idterreno" element={ <TerrenoShow /> } />

                                                <Route path="/servicio/index" element={ <ServicioIndex /> } />
                                                <Route path="/servicio/create" element={ <ServicioCreate /> } />
                                                <Route path="/servicio/edit/:idservicio" element={ <ServicioEdit /> } />
                                                <Route path="/servicio/show/:idservicio" element={ <ServicioShow /> } />

                                                <Route path="/venta/index" element={ <VentaIndex /> } />
                                                <Route path="/venta/create" element={ <VentaCreate /> } />
                                                <Route path="/venta/edit/:idventa" element={ <ServicioEdit /> } />
                                                <Route path="/venta/show/:idventa" element={ <VentaShow /> } />


                                                <Route path="/proveedor/index" element={ <ProveedorIndex /> } />
                                                <Route path="/proveedor/create" element={ <ProveedorCreate /> } />
                                                <Route path="/proveedor/edit/:idproveedor" element={ <ProveedorEdit /> } />
                                                <Route path="/proveedor/show/:idproveedor" element={ <ProveedorShow /> } />


                                                <Route path="/grupousuario/index" element={ <GrupoUsuarioIndex /> } />
                                                <Route path="/grupousuario/create" element={ <GrupoUsuarioCreate /> } />
                                                <Route path="/grupousuario/edit/:idgrupousuario" element={ <GrupoUsuarioEdit /> } />
                                                <Route path="/grupousuario/show/:idgrupousuario" element={ <GrupoUsuarioShow /> } />

                                                <Route path="/formulario/index" element={ <FormularioIndex /> } />
                                                <Route path="/formulario/create" element={ <FormularioCreate /> } />
                                                <Route path="/formulario/edit/:idformulario" element={ <FormularioEdit /> } />
                                                <Route path="/formulario/show/:idformulario" element={ <FormularioShow /> } />

                                                <Route path="/usuario/index" element={ <UsuarioIndex /> } />
                                                <Route path="/usuario/create" element={ <UsuarioCreate /> } />
                                                <Route path="/usuario/edit/:idusuario" element={ <UsuarioEdit /> } />
                                                <Route path="/usuario/show/:idusuario" element={ <UsuarioShow /> } />

                                                <Route path="/usuario/asignar" element={ <AsignarUsuario /> } />
                                                <Route path="/formulario/asignar" element={ <AsignarFormulario /> } />

                                                <Route path="/home" element={ <Home /> } />
                                                
                                            </Routes>

                                        </div>

                                        <div id="styleSelector">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
};

export default AppMain;
