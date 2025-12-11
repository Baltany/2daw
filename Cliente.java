import java.io.IOException;
import java.io.PrintWriter;
import java.net.InetAddress;
import java.net.Socket;
import java.net.UnknownHostException;
import java.util.Scanner;

public class Cliente {
    public static void main(String[] args) {
        int puertoServidor;
        String hostServidor;
        Socket socketComunicacion;
        InetAddress ipServidor;

        if (args.length < 2) {
            System.out.println("Debe pasar el host y el puerto del servidor");
            System.exit(-1);
        }

        hostServidor = args[0];
        puertoServidor = Integer.parseInt(args[1]);

        try {
            socketComunicacion = new Socket(hostServidor, puertoServidor);
            ipServidor = socketComunicacion.getInetAddress();
            System.out.println("Cliente conectado con servidor " + ipServidor.getHostAddress() + ":" + puertoServidor);
            
            // 1. Scanner para leer del SERVIDOR
            Scanner entradaSocket = new Scanner(socketComunicacion.getInputStream());
            // 2. PrintWriter para escribir al SERVIDOR
            PrintWriter salidaSocket = new PrintWriter(socketComunicacion.getOutputStream(), true); // 'true' para auto-flush
            // 3. Scanner para leer de TU TECLADO
            Scanner entradaTeclado = new Scanner(System.in);

            System.out.println("Escribe un mensaje (o enter vacío para salir):");
            System.out.print("> ");

            String mensajeAEnviar;
            
            // Bucle: Lees teclado -> Envías al Server -> Lees respuesta del Server
            while (entradaTeclado.hasNextLine()) {
                mensajeAEnviar = entradaTeclado.nextLine();

                if (mensajeAEnviar.length() == 0) break; // Salir si está vacío

                // Enviar al servidor
                salidaSocket.println(mensajeAEnviar); 
                
                // Esperar eco del servidor
                if (entradaSocket.hasNextLine()) {
                    String eco = entradaSocket.nextLine();
                    System.out.println("Servidor responde: " + eco);
                }
                
                System.out.print("> ");
            }
            
            socketComunicacion.close();

        } catch (UnknownHostException e) {
            System.out.println("Error: No se ha encontrado la IP del servidor.");
            e.printStackTrace();
        } catch (IOException e) {
            System.out.println("Error al establecer conexión con el servidor.");
            e.printStackTrace();
        }
    }
}