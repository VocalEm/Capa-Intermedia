<?php

class Usuarios
{
    private $idUsuario;
    private $nombre;
    private $apellidoPaterno;
    private $apellidoMaterno;
    private $sexo;
    private $correo;
    private $username;
    private $password;
    private $tipoUsuario;
    private $imagen;
    private $fechaNacimiento;
    private $privacidad;

    public function __construct($idUsuario, $nombre, $apellidoPaterno, $apellidoMaterno, $sexo, $correo, $username, $password, $tipoUsuario, $imagen, $fechaNacimiento, $privacidad)
    {
        $this->idUsuario = $idUsuario;
        $this->nombre = $nombre;
        $this->apellidoPaterno = $apellidoPaterno;
        $this->apellidoMaterno = $apellidoMaterno;
        $this->sexo = $sexo;
        $this->correo = $correo;
        $this->username = $username;
        $this->password = $password;
        $this->tipoUsuario = $tipoUsuario;
        $this->imagen = $imagen;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->privacidad = $privacidad;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellidoPaterno()
    {
        return $this->apellidoPaterno;
    }

    public function getApellidoMaterno()
    {
        return $this->apellidoMaterno;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getTipoUsuario()
    {
        return $this->tipoUsuario;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function getPrivacidad()
    {
        return $this->privacidad;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellidoPaterno($apellidoPaterno)
    {
        $this->apellidoPaterno = $apellidoPaterno;
    }

    public function setApellidoMaterno($apellidoMaterno)
    {
        $this->apellidoMaterno = $apellidoMaterno;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setTipoUsuario($tipoUsuario)
    {
        $this->tipoUsuario = $tipoUsuario;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function setPrivacidad($privacidad)
    {
        $this->privacidad = $privacidad;
    }
}
