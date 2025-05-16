<?php

namespace App\Controllers;

use App\Helpers\UsuarioSesion;
use App\Models\Categoria;

class AgregarProductoController
{
    public function mostrarFormulario()
    {
        UsuarioSesion::iniciar();
        $title = 'Agregar Producto';
        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->obtenerCategorias();
        require_once '../app/views/agregarProducto.php';
    }

    public function agregarCategoria()
    {
        $title = 'Agregar Producto';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria = trim($_POST['nueva_categoria']);
            $errores = [];
            $idCreador = UsuarioSesion::obtener()['id']; // ID del usuario logueado

            if (empty($categoria)) {
                $errores[] = "El campo de categoría no puede estar vacío.";
            }

            if (strlen($categoria) > 100) {
                $errores[] = "La categoría no puede tener más de 100 caracteres.";
            }

            if (empty($errores)) {
                $categoriaModel = new Categoria();
                $datos = [
                    'titulo' => $categoria,
                    'id_creador' => $idCreador
                ];

                if ($categoriaModel->agregarCategoria($datos)) {
                    $_SESSION['exito'] = "Categoría agregada correctamente.";
                    header("Location: /agregar-producto");
                    exit;
                } else {
                    $errores[] = "Error al agregar la categoría.";
                }
            }

            $_SESSION['errores'] = $errores;
            header("Location: /agregar-producto");
            exit;
        }
    }

    public function agregarProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $stock = (int) $_POST['stock'];
            $tipoVenta = $_POST['tipo_venta'];
            $precio = ($tipoVenta === 'venta') ? (float) $_POST['precio'] : null;
            $idVendedor = UsuarioSesion::obtener()['id'];
            $categorias = $_POST['categorias'] ?? [];
            $imagenes = $_FILES['imagenes'];
            $videos = $_FILES['videos'];
            $errores = [];

            // Validaciones Básicas
            if (empty($nombre)) $errores[] = "El nombre del producto no puede estar vacío.";
            if (empty($descripcion)) $errores[] = "La descripción del producto no puede estar vacía.";
            if ($stock < 0) $errores[] = "La cantidad en stock debe ser mayor o igual a 0.";
            if ($tipoVenta === "") $errores[] = "Debe seleccionar un tipo de venta.";
            if ($tipoVenta === "fijo" && ($precio === null || $precio <= 0)) {
                $errores[] = "Si el tipo de venta es 'Precio Fijo', el precio debe ser mayor a 0.";
            }
            if (empty($categorias)) $errores[] = "Debe seleccionar al menos una categoría.";

            // Validación de Imágenes
            $totalImagenes = count(array_filter($imagenes['name']));
            if ($totalImagenes < 3) {
                $errores[] = "Debe cargar al menos 3 imágenes.";
            }

            // Validación de Videos
            $totalVideos = count(array_filter($videos['name']));
            if ($totalVideos < 1) {
                $errores[] = "Debe cargar al menos 1 video.";
            }

            // Si hay errores, redirigimos con los errores
            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                header("Location: /agregar-producto");
                exit;
            }

            // Crear el Producto
            $productoModel = new \App\Models\Producto();
            $productoId = $productoModel->crearProducto([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'stock' => $stock,
                'tipo_publicacion' => $tipoVenta,
                'id_vendedor' => $idVendedor
            ]);

            if (!$productoId) {
                $_SESSION['errores'][] = "Error al crear el producto.";
                header("Location: /agregar-producto");
                exit;
            }

            // Asociar Categorías
            if (!$productoModel->asociarCategorias($productoId, $categorias)) {
                $_SESSION['errores'][] = "Error al asociar categorías.";
            }

            // Procesar Imágenes
            $imagenesGuardadas = $this->procesarMultimedia($imagenes);
            echo $imagenesGuardadas;
            if (!$productoModel->guardarMultimedia($productoId, $imagenesGuardadas)) {
                $_SESSION['errores'][] = "Error al guardar imágenes.";
            }

            // Procesar Videos
            $videosGuardados = $this->procesarMultimedia($videos);
            echo $videosGuardados;
            if (!$productoModel->guardarMultimedia($productoId, $videosGuardados)) {
                $_SESSION['errores'][] = "Error al guardar videos.";
            }

            // Redireccionar con éxito o errores
            if (empty($_SESSION['errores'])) {
                $_SESSION['exito'] = "Producto agregado correctamente.";
            }

            header("Location: /agregar-producto");
            exit;
        }
    }

    private function procesarMultimedia($files)
    {
        $rutasGuardadas = [];

        if (!empty($files['name'][0])) {
            foreach ($files['tmp_name'] as $index => $tmpName) {
                if ($files['error'][$index] === UPLOAD_ERR_OK) {

                    // Nombre original del archivo
                    $nombreOriginal = $files['name'][$index];

                    // Remover espacios y reemplazarlos por guiones bajos
                    $nombreLimpio = preg_replace('/\s+/', '_', $nombreOriginal);

                    // Remover caracteres especiales dejando solo letras, números, guiones bajos, puntos y guiones
                    $nombreLimpio = preg_replace('/[^A-Za-z0-9_.-]/', '', $nombreLimpio);

                    // Generar un nombre único
                    $nombreArchivo = uniqid() . '_' . $nombreLimpio;

                    // Ruta final donde se guardará el archivo
                    $ruta = '../app/uploads/' . $nombreArchivo;

                    // Mover el archivo
                    if (move_uploaded_file($tmpName, $ruta)) {
                        $rutasGuardadas[] = $nombreArchivo;
                    }
                }
            }
        }

        return $rutasGuardadas;
    }
}

// hay que revisar las validaciones con el rol