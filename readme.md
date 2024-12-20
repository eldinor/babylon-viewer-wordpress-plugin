# Babylon Viewer v2 3D Wordpress 3D Plugin

### Version 1.1 alpha

![](https://img.shields.io/badge/Wordpress%203DViewer-navy)
![](https://img.shields.io/badge/maturity-alpha-blue)
![](https://img.shields.io/badge/development-active-yellow)
![](https://img.shields.io/badge/Mood-Good-lime)
![](https://img.shields.io/badge/BabylonPress.org-navy)

##### Successfully tested with Wordpress 6.6.2

Display 3D models with the help of shortcode:

[babylonviewer]URL-OF-3D-FILE[/babylonviewer]

to use the Babylon Viewer v2 in Wordpress posts and pages, Woocommerce products, Elementor blocks etc.

Supports **GLTF, GLB, STL, OBJ+MTL** files upload and demonstration as a viewing experience for 3D models. All aspects of this experience are configurable. If you need more control, you may use <babylon-viewer></babylon-viewer> tag in any Wordpress HTML block and configure all needed parameters with JS.

Supports models from **external URLs**.

**Doesn't write any data to WP database.**

**Shortcode:**

[babylonviewer]URL-OF-3D-FILE[/babylonviewer].

**Demo**: https://viewer.babylonpress.org/

## Installation and Usage

0. Download the latest zip from Github repository.
1. Standard WordPress plugin installation: go to Plugins -> Add New – upload .zip file.
   **If you use older version of this plugin, first deactivate it and delete**. Plugin doesn't contain any user data.
2. Activate the plugin.
3. **Upload** 3D file in **GLTF, GLB, STL, OBJ+MTL** format. If you upload OBJ file, make sure to upload corresponding MTL file too.
   **Or use external URL** - link to the 3D file.
4. **Publish** in **WordPress posts and pages, Woocommerce products, Elementor blocks** etc with the help of **shortcode**:
   [babylonviewer]Url-Of-3D-File[/babylonviewer]
   Make sure there are **no spaces** between URL and shortcode brackets[babylonviewer]**URL**[/babylonviewer].
5. Another option is to publish 3D files with the standard WordPress HTML block and have more ways to configure Babylon Viewer. You may adjust all needed parameters (light, camera position, camera behaviour, rotating etc), create our own Viewer instance, change UI etc.

### Shortcode Example

Just put it into standard Wordpress Shortcode Gutenberg block and publish:

`[babylonviewer]https://playground.babylonjs.com/scenes/BoomBox.glb[/babylonviewer]`

### HTML Example

Just put it into standard **Wordpress HTML Gutenberg block** and publish:

`<babylon-viewer
  source="https://playground.babylonjs.com/scenes/BoomBox.glb" environment="https://unpkg.com/@babylonjs/viewer@preview/assets/photoStudio.env"></babylon-viewer>`

Read more about Babylon Viewer v2 settings at https://doc.babylonjs.com/features/featuresDeepDive/babylonViewer/

Viewer v2 Source - [https://github.com/BabylonJS/Babylon.js/tree/master/packages/public/@babylonjs/viewer-alpha](https://github.com/BabylonJS/Babylon.js/tree/master/packages/public/@babylonjs/viewer-alpha)

**Wordpress Demo**: https://viewer.babylonpress.org/

## Changelog

#### Version 1.0

Version number one.

#### Version 1.1

CDN link changed to jsdelivr.
