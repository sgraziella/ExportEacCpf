# ExportEacCpf

_*Work in progress*_

*ExportEacCpf* is a plugin for [Omeka](https://omeka.org/) that allows to export data as basic [EAC-CPF](http://eac.staatsbibliothek-berlin.de/index.php), an XML-Schema providing a grammar for encoding names of creators of archival materials and related information. 

For the moment, since Omeka data input interface does not have a general way to manage multiple levels of description or allow to simulate hierarchical elements, *ExportEacCpf* plugin just consider a limited set of EAC-CPF elements, some of them need to be reworked a little bit on the output file.

This plugin could be used in combination with [XmlImport](https://github.com/Daniel-KM/XmlImport), after a proper [XSL tranformation](https://github.com/sgraziella/prosopography_LJP/tree/master/EACtoXML), in order to manage by Omeka a simple cycle of Importing/Exporting EAC-CPF data. 
An example of this kind of data processing cycle is put in place on this project: [http://josticeetplet.huma-num.fr/](http://josticeetplet.huma-num.fr/)


## Installation and Specifications
1. Download the *ExportEacCpf* plugin directory;
2. Take a look on *helpers/EacCpfExporter.php* and configure which fields you want to use. In order to used the default configuration, you need to create a new Item Type using the Omeka interface (we called that EAC-CPF Item Type Metadata) or modify an existing Item Type by adding the EAC-CPF elements listing below;
3. Upload the *ExportEacCpf* plugin directory to your Omeka installation's *plugins* directory;
4. Activate the plugin from the Admin → Settings → Plugins page.

The export is based on this following fields, both for Dublin Core and Item Type Metadata Set :

##### Dublin Core 
- Accrual Method
- Accrual Policy
- Conforms To
- Creator
- Date Created
- Identifier
- Instructional Method
- Language
- Publisher
- Title
- Type

##### EAC-CPF Item Type Metadata
- Biography or Historical Note
- Dates of Existence
- Functions
- Name Entry Parallel
- Places
- Relations
- Sources

EAC-CPF Item Type Metadata is a basic set of Item Types Elements you could modify according to yours needs. This is the setting we use:

![Image of EAC-CPF Type](https://github.com/sgraziella/ExportEacCpf/blob/master/Person-EAC-CPF-ElementTypeFR.png)


## Licence
This plugin is released under the [BSD 2-Clause License](https://opensource.org/licenses/BSD-2-Clause)


## Credits
- Created by [Graziella Pastore](https://github.com/sgraziella), [Ecole nationale des chartes](http://www.enc-sorbonne.fr/fr/graziella-pastore) - [INRIA](http://www.inria.fr/), Paris
- With the strong support of [Luca Foppiano](https://github.com/lfoppiano), [INRIA](http://www.inria.fr/), Paris
