import "./common";
import.meta.glob(["../img/**"]);
import Spotlight from "spotlight.js";

import Sortable from "sortablejs";
window.Sortable = Sortable;

import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.min.css";
window.TomSelect = TomSelect;

import * as FilePond from "filepond";
import "filepond/dist/filepond.min.css";
import pt_BR from "filepond/locale/pt-br.js";
FilePond.setOptions(pt_BR);
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";
FilePond.registerPlugin(FilePondPluginImagePreview);
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
FilePond.registerPlugin(FilePondPluginFileValidateSize);
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
FilePond.registerPlugin(FilePondPluginFileValidateType);
window.FilePond = FilePond;
