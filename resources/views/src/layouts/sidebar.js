
import React, { Component } from 'react';
import { useNavigate } from 'react-router-dom';

function Sidebar() {
    const navigate = useNavigate();

    return (
        <>
            <SidebarPrivate 
                navigate={navigate}
            />
        </>
    );
};

class SidebarPrivate extends Component {

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
            <>
                <nav className="pcoded-navbar">
                    <div className="pcoded-inner-navbar main-menu">
                        <div className="pcoded-navigatio-lavel">Inicio</div>
                        <ul className="pcoded-item pcoded-left-item">
                            <li className="">
                                <a href="/home" >
                                    <span className="pcoded-mtext">
                                        Inicio
                                    </span>
                                </a>
                            </li>
                            <li className="pcoded-hasmenu active pcoded-trigger">
                                <a href="#">
                                    <span className="pcoded-micon"><i className="feather icon-home"></i></span>
                                    <span className="pcoded-mtext">Venta</span>
                                </a>
                                <ul className="pcoded-submenu">
                                    <li className="">
                                        <a href="#" 
                                            onClick={ ( evt ) => {
                                                evt.preventDefault();
                                                this.props.navigate( "/venta/index" );
                                            } }
                                        >
                                            <span className="pcoded-mtext">
                                                Venta
                                            </span>
                                        </a>
                                    </li>
                                    <li className="">
                                        <a href="#" 
                                            onClick={ ( evt ) => {
                                                evt.preventDefault();
                                                this.props.navigate( "/cliente/index" );
                                            } }
                                        >
                                            <span className="pcoded-mtext">
                                                Cliente
                                            </span>
                                        </a>
                                    </li>
                                    <li className="">
                                        <a href="#" 
                                            onClick={ ( evt ) => {
                                                evt.preventDefault();
                                                this.props.navigate( "/terreno/index" );
                                            } }
                                        >
                                            <span className="pcoded-mtext">
                                                Terreno
                                            </span>
                                        </a>
                                    </li>
                                    <li className="">
                                        <a href="#" 
                                            onClick={ ( evt ) => {
                                                evt.preventDefault();
                                                this.props.navigate( "/servicio/index" );
                                            } }
                                        >
                                            <span className="pcoded-mtext">
                                                Servicio
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {/* <li className="pcoded-hasmenu">
                                <a href="#">
                                    <span className="pcoded-micon"><i className="feather icon-home"></i></span>
                                    <span className="pcoded-mtext">Compra</span>
                                </a>
                                <ul className="pcoded-submenu">
                                    <li className="">
                                        <a href="#" 
                                            onClick={ ( evt ) => {
                                                evt.preventDefault();
                                                this.props.navigate( "/proveedor/index" );
                                            } }
                                        >
                                            <span className="pcoded-mtext">
                                                Proveedor
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li> */}
                            <li className="pcoded-hasmenu">
                                <a href="#" onClick={ (evt) => evt.preventDefault() }>
                                    <span className="pcoded-micon"><i className="feather icon-sidebar"></i></span>
                                    <span className="pcoded-mtext">Usuario</span>
                                </a>
                                <ul className="pcoded-submenu">
                                    <li className="">
                                        <a href="menu-bottom.html"
                                            onClick={ ( evt ) => {
                                                evt.preventDefault();
                                                this.props.navigate( "/usuario/index" );
                                            } }
                                        >
                                            <span className="pcoded-mtext">Usuario</span>
                                        </a>
                                    </li>
                                    <li className="">
                                        <a href="menu-bottom.html"
                                            onClick={ ( evt ) => {
                                                evt.preventDefault();
                                                this.props.navigate( "/grupousuario/index" );
                                            } }
                                        >
                                            <span className="pcoded-mtext">Grupo Usuario</span>
                                        </a>
                                    </li>
                                    <li className="">
                                        <a href="menu-bottom.html"
                                            onClick={ ( evt ) => {
                                                evt.preventDefault();
                                                this.props.navigate( "/formulario/index" );
                                            } }
                                        >
                                            <span className="pcoded-mtext">
                                                Permiso
                                            </span>
                                        </a>
                                    </li>
                                    <li className="">
                                        <a href="menu-bottom.html"
                                            onClick={ ( evt ) => {
                                                evt.preventDefault();
                                                this.props.navigate( "/formulario/asignar" );
                                            } }
                                        >
                                            <span className="pcoded-mtext">Asignar Permiso</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </>
        );
    };
};

export default Sidebar;
