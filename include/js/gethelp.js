
function getFuncHelp(fid) {
	switch(fid) {
		case "GCOM01" : return "- �������� : Ŀ�´�Ƽ ȸ������ ������ ���������� �Է��ϴ� �Խ����Դϴ�. "
		case "GCOM02" : return "- �ϹݰԽ��� : Ŀ�´�Ƽ ������ ��� �� �Խ����Դϴ�. ���ݿ� �°� �Խ��� ���� ���Ͻʽÿ�."
		case "GCOM03" : return "- �亯�Խ��� : Ŀ�´�Ƽ ������ ��� �� �Խ����Դϴ�. ���ݿ� �°� �Խ��� ���� ���Ͻʽÿ�."
		case "GCOM04" : return "- �ڷ�� : Ŀ�´�Ƽ �ڷ���Դϴ�."
		case "GCOM05" : return "- ���� : Ŀ�´�Ƽ �湮���� �̿� �� �����Դϴ�."
		case "GCOM06" : return "- ���ٸ޸�  : ���ٸ޸�(�ڸ�Ʈ ��ɰ�ȭ)�� �⼮üũ�� �����մϴ�."
		case "GCOM08" : return "- �ٹ�  : Ŀ�´�Ƽ �ٹ��Դϴ�."

		case "TCOM01" : return "- Ÿ��Ʋ  : �޴��� Ÿ��Ʋ�� �����մϴ�."
		case "TCOM02" : return "- �޴����м� : �޴��� �޴������� ���м��� �߰��մϴ�."
//		case "TCOM03" : return "- �����Խ���  : ȸ����޺� ������ �ǰ߹��⸦ �����մϴ�."
		case "TCOM03" : return "- �����ڷ��  : ȸ����޺� ������ �ǰ߹��⸦ �����մϴ�."
		case "TCOM04" : return "- �����ڷ��  : ȸ����޺� �� �����մϴ�."
		case "TCOM05" : return "- �����ڷ��  : ȸ����޺� �� �����մϴ�."
		case "TCOM06" : return "- �׸��ڷ��  : ȸ����޺� �� �����մϴ�."
		default : return ""
	}
}

function getFuncName(fid) {
	switch(fid) {
		case "GCOM01" : return "[��������]"
		case "GCOM02" : return "[���հԽ���]"
		case "GCOM03" : return "[���հԽ���]"
		case "GCOM04" : return "[���հԽ���]"
		case "GCOM05" : return "[�޸�Խ���]"
		case "GCOM06" : return "[�޸�Խ���]"
		case "GCOM08" : return "[�����Խ���]"

		case "TCOM01" : return "[Ÿ��Ʋ]"
		case "TCOM02" : return "[���м�]"
//		case "TCOM03" : return "[�����Խ���]"
		case "TCOM03" : return "[�����ڷ��]"
		case "TCOM04" : return "[�����ڷ��]"
		case "TCOM05" : return "[�����ڷ��]"
		case "TCOM06" : return "[�׸��ڷ��]"

		default : return "[]"
	}
}

function getFuncMulti(fid) {
	switch(fid) {
		case "GCOM01":

			return false
		default:
			return true
	}
}
