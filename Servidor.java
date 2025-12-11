import java.io.IOException;
import java.io.PrintWriter;
import java.net.InetAddress;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.NoSuchElementException;
import java.util.Scanner;

public class Servidor extends Thread {
    private Socket socketComunicacion;

    public Servidor(Socket socket) {
        socketComunicacion = socket;
    }

    @Override
    public void run() {
        InetAddress ipCliente;

        try {
            // Scanner para leer lo que llega del CLIENTE
            Scanner entradaSocket = new Scanner(socketComunicacion.getInputStream());
            // PrintWriter para enviar datos al CLIENTE
            PrintWriter salidaSocket = new PrintWriter(socketComunicacion.getOutputStream(), true);
            
            // NUEVO: Scanner para leer lo que TÚ escribes en el servidor
            Scanner entradaTeclado = new Scanner(System.in); 

            System.out.println("Esperando mensaje del cliente...");
            String lineaRecibida;

            // Bucle de comunicación
            while (entradaSocket.hasNextLine()) {
                lineaRecibida = entradaSocket.nextLine();
                ipCliente = socketComunicacion.getInetAddress();
                
                // 1. Mostrar lo que dijo el cliente
                System.out.printf("[%s:%d] dice: %s%n",
                        ipCliente.getHostAddress(), socketComunicacion.getPort(), lineaRecibida);

                // 2. Pedir al usuario del servidor que responda
                System.out.print("Tu respuesta > ");
                String miRespuesta = entradaTeclado.nextLine(); // <--- AQUÍ SE DETIENE ESPERANDO QUE ESCRIBAS

                // 3. Enviar tu respuesta al cliente
                salidaSocket.println(miRespuesta);
            }

        } catch (IOException exception) {
            System.out.println("Error de E/S");
        } catch (NoSuchElementException e) {
            System.out.println("El cliente ha cerrado la conexión.");
        } finally {
            try {
                if (socketComunicacion != null) socketComunicacion.close();
                System.out.println("Socket cerrado.");
            } catch (IOException ex) {
                ex.printStackTrace();
            }
        }
    }

    public static void main(String[] args) {
        int numPuertoServidor;
        ServerSocket socketServidor;

        if (args.length < 1) {
            System.out.println("Debes pasar el puerto");
            System.exit(-1);
        }

        numPuertoServidor = Integer.parseInt(args[0]);

        try {
            socketServidor = new ServerSocket(numPuertoServidor);
            System.out.println("Servidor escuchando en el puerto " + numPuertoServidor);
            
            while (true) {
                Socket socketComunicacion = socketServidor.accept();
                System.out.printf("Conexión establecida con cliente%n");
                
                Servidor hiloServidor = new Servidor(socketComunicacion);
                hiloServidor.start();
            }
        } catch (IOException e) {
            System.out.println("Error de flujo E/S");
            throw new RuntimeException(e);
        }
    }
}