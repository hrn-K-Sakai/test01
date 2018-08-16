import java.util.Scanner;

/**
 * ���s�̓���
 */
public class Main {
	public static void main(String[] args){
		// �����Ɗ��Ԃ����
		Scanner sc = new Scanner(System.in);
		int inputDate = sc.nextInt();
		int inputPeriod = sc.nextInt();
		Integer[] inputDates = new Integer[inputDate];
		Integer[] inputProb = new Integer[inputDate];
		Double[] avgProb = new Double[inputDate - inputPeriod + 1];
		
		// ���t�ƍ~���m�������
		for (int i = 0; i < inputDate; i++) {
			inputDates[i] = sc.nextInt();
			inputProb[i] = sc.nextInt();
		}
		
		// ���ύ~���m�������߂Ĕz��Ɋi�[
		for (int i = 0; i <= (inputDate - inputPeriod); i++) {
			double avg = 0;
			for (int j = i; j <= (i + inputPeriod - 1); j++) {
				avg += inputProb[j];
			}
			avgProb[i] = avg / inputPeriod;
		}
		
		// �Œᕽ�ύ~���m�������߂�
		double minProb = avgProb[0];
		int result = 0;
		for (int i = 0; i < avgProb.length; i++) {
			if (avgProb[i] < minProb) {
				minProb = avgProb[i];
				result = i;
			}
		}
		int start = inputDates[result];
		int end = inputDates[result] + inputPeriod - 1;
		
		// ��ʂɏo��
		System.out.println(start + " " + end);
	}
}