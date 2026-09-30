

import Alpine from 'alpinejs';
import { ArrowLeft, ArrowRight, ArrowUpRight, BadgeAlert, BadgeCheck, Church, ChevronDown, Cross, Download, FilePlus2, History, IdCard, List, Menu, Network, Pencil, Plus, Printer, Save, UserPlus, UsersRound, X, createIcons } from 'lucide';
import QRCode from 'qrcode';

window.Alpine = Alpine;

createIcons({ icons: { ArrowLeft, ArrowRight, ArrowUpRight, BadgeAlert, BadgeCheck, Church, ChevronDown, Cross, Download, FilePlus2, History, IdCard, List, Menu, Network, Pencil, Plus, Printer, Save, UserPlus, UsersRound, X } });
Alpine.start();

document.querySelectorAll('[data-qr-value]').forEach((canvas) => {
	QRCode.toCanvas(canvas, canvas.dataset.qrValue, {
		width: 128,
		margin: 1,
		color: { dark: '#123c35', light: '#ffffff' },
	});
});
